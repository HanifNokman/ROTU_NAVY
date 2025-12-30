<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\PerformanceRating;

class PersonalInfoController extends Controller
{
    /**
     * Display the user's personal information form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $personal = $user->role === 'cadet'
            ? Cadet::where('user_id', $user->id)->first()
            : Instructor::where('user_id', $user->id)->first();

        return view('profile.edit', [
            'user' => $user,
            'personal' => $personal,
        ]);
    }

    /**
     * Handle profile picture upload with optimization and error handling.
     */
    private function handleProfilePictureUpload($request, $existingPicture = null)
    {
        if (!$request->hasFile('profile_pic')) {
            return null;
        }

        $image = $request->file('profile_pic');

        // Check if upload was successful
        if (!$image->isValid()) {
            throw new \Exception('File upload failed. The file may be corrupted or too large.');
        }

        try {
            // Optimize and compress the image
            $optimizedImagePath = $this->optimizeImage($image);

            // Delete old profile picture if exists
            if (!empty($existingPicture) && Storage::disk('public')->exists($existingPicture)) {
                Storage::disk('public')->delete($existingPicture);
            }

            return $optimizedImagePath;

        } catch (\Exception $e) {
            Log::error('Profile picture upload failed', [
                'error' => $e->getMessage(),
                'file' => $image->getClientOriginalName(),
                'size' => $image->getSize()
            ]);
            throw new \Exception('Failed to save profile picture. Please try a smaller image (under 2MB).');
        }
    }

    /**
     * Optimize image by resizing and compressing.
     */
    private function optimizeImage($uploadedFile)
    {
        // Create a unique filename
        $filename = time() . '_' . uniqid() . '.jpg';
        $path = 'profile_pics/' . $filename;

        // Get image info
        $imageInfo = getimagesize($uploadedFile->getPathname());
        if (!$imageInfo) {
            throw new \Exception('Invalid image file');
        }

        // Create image resource based on mime type
        $sourceImage = match($imageInfo['mime']) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($uploadedFile->getPathname()),
            'image/png' => imagecreatefrompng($uploadedFile->getPathname()),
            'image/gif' => imagecreatefromgif($uploadedFile->getPathname()),
            default => throw new \Exception('Unsupported image type')
        };

        if (!$sourceImage) {
            throw new \Exception('Failed to process image');
        }

        // Calculate new dimensions (max 800x800, maintain aspect ratio)
        $maxSize = 800;
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        if ($width > $maxSize || $height > $maxSize) {
            if ($width > $height) {
                $newWidth = $maxSize;
                $newHeight = (int)(($height / $width) * $maxSize);
            } else {
                $newHeight = $maxSize;
                $newWidth = (int)(($width / $height) * $maxSize);
            }
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        // Create new image with optimized size
        $optimizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($imageInfo['mime'] === 'image/png') {
            imagealphablending($optimizedImage, false);
            imagesavealpha($optimizedImage, true);
        }

        // Resize image
        imagecopyresampled(
            $optimizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        // Save optimized image to storage
        $fullPath = storage_path('app/public/' . $path);
        $directory = dirname($fullPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save as JPEG with 85% quality (good balance between quality and size)
        $saved = imagejpeg($optimizedImage, $fullPath, 85);

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($optimizedImage);

        if (!$saved) {
            throw new \Exception('Failed to save optimized image');
        }

        return $path;
    }

    /**
     * Update the user's personal information.
     */

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'cadet') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'ic_number' => 'nullable|string|max:15',
                'matric_no' => 'nullable|string|max:11',
                'intake_year' => 'nullable|digits:4',
                'service_number' => 'nullable|string|max:10',
                'rank' => 'nullable|string',
                'bank_account_number' => 'nullable|string|max:15',
                'current_cgpa' => 'nullable|numeric|between:0,4.00',
                'past_cgpa' => 'nullable|numeric|between:0,4.00',
                'faculty' => 'nullable|string|max:100',
                'course' => 'nullable|string|max:100',
                'BMI' => 'nullable|numeric',
                'ttp_date' => 'nullable|date',
                'insurance_number' => 'nullable|string|max:50',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $cadet = Cadet::where('user_id', $user->id)->first();
            if (!$cadet) {
                $cadet = new Cadet(['user_id' => $user->id]);
            }

            // Handle profile picture upload with optimization and error handling
            try {
                $imagePath = $this->handleProfilePictureUpload($request, $cadet->profile_pic);
                if ($imagePath) {
                    $validated['profile_pic'] = $imagePath;
                }
            } catch (\Exception $e) {
                return Redirect::route('personal.edit')
                    ->withErrors(['profile_pic' => $e->getMessage()])
                    ->withInput();
            }
            $oldBMI = $cadet->BMI;
            $oldCGPA = $cadet->current_cgpa;

            // Define fields that can only be filled once
            $oneTimeFillFields = ['gender', 'ic_number', 'matric_no', 'intake_year', 'rank'];

            // Only update fields present in the request, preserve others
            foreach ($validated as $key => $value) {
                if ($request->has($key) || $key === 'profile_pic') {
                    // Check if this is a one-time fill field
                    if (in_array($key, $oneTimeFillFields)) {
                        // Only allow update if the field is currently empty/null
                        if (empty($cadet->$key)) {
                            $cadet->$key = $value;
                        }
                        // If field already has a value, skip the update (preserve existing value)
                    } else {
                        // For non-restricted fields, update normally
                        $cadet->$key = $value;
                    }
                }
            }

            // If BMI is being updated, set BMI_update_date to now
            if (array_key_exists('BMI', $validated) && $validated['BMI'] !== null && $validated['BMI'] != $oldBMI) {
                $cadet->BMI_update_date = now();
            }

            $cadet->save();

            // Update performance rating if CGPA changed
            if (array_key_exists('current_cgpa', $validated) && $validated['current_cgpa'] != $oldCGPA) {
                $performanceRating = PerformanceRating::getOrCreateForCadet($cadet->id);
                $performanceRating->updateAcademicPoints();
            }

        } elseif ($user->role === 'instructor') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'position' => 'nullable|string|max:20',
                'expertise' => 'nullable|string',
                'past_unit' => 'nullable|array',
                'service_number' => 'nullable|string|max:10',
                'rank' => 'nullable|string',
                'status' => 'nullable|string',
                'time_in_service' => 'nullable|integer|min:0',
                'ttp' => 'nullable|date',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $instructor = Instructor::where('user_id', $user->id)->first();
            if (!$instructor) {
                $instructor = new Instructor(['user_id' => $user->id]);
            }

            // Handle profile picture upload with optimization and error handling
            try {
                $imagePath = $this->handleProfilePictureUpload($request, $instructor->profile_pic);
                if ($imagePath) {
                    $validated['profile_pic'] = $imagePath;
                }
            } catch (\Exception $e) {
                return Redirect::route('personal.edit')
                    ->withErrors(['profile_pic' => $e->getMessage()])
                    ->withInput();
            }

            // Handle past_unit array - filter out empty values and encode as JSON
            if (isset($validated['past_unit'])) {
                $validated['past_unit'] = json_encode(array_filter($validated['past_unit'], function($value) {
                    return !empty(trim($value));
                }));
            }

            foreach ($validated as $key => $value) {
                if ($request->has($key) || $key === 'profile_pic' || $key === 'past_unit') {
                    $instructor->$key = $value;
                }
            }
            $instructor->save();
        }

        return Redirect::route('personal.edit')->with('status', 'personal-updated');
    }
}