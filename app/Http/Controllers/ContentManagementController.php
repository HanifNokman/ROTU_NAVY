<?php

namespace App\Http\Controllers;

use App\Models\ContentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContentManagementController extends Controller
{
    /**
     * Update content settings
     */
    public function update(Request $request)
    {
        // Check if user is instructor or admin
        if (!in_array(auth()->user()->role, ['instructor', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'application_deadline' => 'nullable|date|after:today',
            'application_portal_url' => 'nullable|url',
            'qr_code_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'intro_description' => 'nullable|string|max:2000',
            'about_description' => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Update application deadline
            if ($request->filled('application_deadline')) {
                ContentSetting::set(
                    'application_deadline',
                    $request->application_deadline,
                    'date',
                    'Application deadline date for PALAPES program'
                );
            }

            // Update application portal URL
            if ($request->filled('application_portal_url')) {
                ContentSetting::set(
                    'application_portal_url',
                    $request->application_portal_url,
                    'url',
                    'URL for the application portal'
                );
            }

            // Handle QR code image upload
            if ($request->hasFile('qr_code_image')) {
                $file = $request->file('qr_code_image');
                
                // Delete old QR code if exists
                $oldQrCode = ContentSetting::get('qr_code_image');
                if ($oldQrCode && Storage::disk('public')->exists(str_replace('storage/', '', $oldQrCode))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $oldQrCode));
                }

                // Store new QR code
                $fileName = 'qr_code_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('qr-codes', $fileName, 'public');
                
                ContentSetting::set(
                    'qr_code_image',
                    'storage/' . $path,
                    'file',
                    'QR code image for quick access'
                );
            }

            // Update text content
            $textFields = ['hero_title', 'hero_subtitle', 'intro_description', 'about_description'];
            foreach ($textFields as $field) {
                if ($request->filled($field)) {
                    ContentSetting::set(
                        $field,
                        $request->$field,
                        'text',
                        ucfirst(str_replace('_', ' ', $field))
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully!',
                'data' => [
                    'show_banner' => ContentSetting::shouldShowDeadlineBanner(),
                    'formatted_deadline' => ContentSetting::getFormattedDeadline(),
                    'qr_code_url' => ContentSetting::get('qr_code_image'),
                    'portal_url' => ContentSetting::get('application_portal_url'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current content settings
     */
    public function getCurrentSettings()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'application_deadline' => ContentSetting::get('application_deadline'),
                'application_portal_url' => ContentSetting::get('application_portal_url'),
                'qr_code_image' => ContentSetting::get('qr_code_image'),
                'hero_title' => ContentSetting::get('hero_title'),
                'hero_subtitle' => ContentSetting::get('hero_subtitle'),
                'intro_description' => ContentSetting::get('intro_description'),
                'about_description' => ContentSetting::get('about_description'),
                'show_banner' => ContentSetting::shouldShowDeadlineBanner(),
                'formatted_deadline' => ContentSetting::getFormattedDeadline(),
            ]
        ]);
    }

    /**
     * Reset content to defaults
     */
    public function resetToDefaults()
    {
        // Check if user is instructor or admin
        if (!in_array(auth()->user()->role, ['instructor', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        try {
            ContentSetting::set('application_deadline', '2025-03-31', 'date');
            ContentSetting::set('application_portal_url', 'https://application.ums.edu.my/palapes', 'url');
            ContentSetting::set('hero_title', 'Excellence in Maritime Leadership', 'text');
            ContentSetting::set('hero_subtitle', 'Forge your path as a naval officer through comprehensive training, leadership development, and academic excellence at Universiti Malaysia Sabah', 'text');
            ContentSetting::set('intro_description', 'The Reserve Officer Training Unit (PALAPES) represents Malaysia\'s premier naval leadership development program, combining rigorous academic excellence with comprehensive military training to forge the next generation of maritime leaders.', 'text');
            ContentSetting::set('about_description', 'With decades of proven success, PALAPES has established itself as the premier institution for developing maritime leaders who serve with distinction in both military and civilian capacities, upholding the highest standards of honor, courage, and commitment.', 'text');

            return response()->json([
                'success' => true,
                'message' => 'Content reset to defaults successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while resetting content: ' . $e->getMessage()
            ], 500);
        }
    }
}