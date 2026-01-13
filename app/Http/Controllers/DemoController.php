<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DemoController extends Controller
{
    public function index()
    {
        // Check if demo video exists
        $videoPath = null;
        if (Storage::disk('public')->exists('demo/demo-video.mp4')) {
            $videoPath = asset('storage/demo/demo-video.mp4');
        }

        return view('demo', compact('videoPath'));
    }

    public function uploadVideo(Request $request)
    {
        // Check if user is authenticated and is instructor or admin
        if (!Auth::check() || !in_array(Auth::user()->role, ['instructor', 'admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv|max:358400' // Max 350MB
        ]);

        try {
            // Delete old video if exists
            if (Storage::disk('public')->exists('demo/demo-video.mp4')) {
                Storage::disk('public')->delete('demo/demo-video.mp4');
            }

            // Store new video
            $path = $request->file('video')->storeAs(
                'demo',
                'demo-video.mp4',
                'public'
            );

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'video_url' => asset('storage/' . $path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload video: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteVideo()
    {
        // Check if user is authenticated and is instructor or admin
        if (!Auth::check() || !in_array(Auth::user()->role, ['instructor', 'admin'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            if (Storage::disk('public')->exists('demo/demo-video.mp4')) {
                Storage::disk('public')->delete('demo/demo-video.mp4');
                return response()->json([
                    'success' => true,
                    'message' => 'Video deleted successfully'
                ]);
            }

            return response()->json(['error' => 'Video not found'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete video: ' . $e->getMessage()
            ], 500);
        }
    }
}
