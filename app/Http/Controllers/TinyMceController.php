<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMceController extends Controller
{
    /**
     * Handle TinyMCE image uploads
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $file = $request->file('file');

        // Validate file
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf,doc,docx,xls,xlsx|max:5120', // 5MB max
        ]);

        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

        // Store file
        $path = $file->storeAs('public/uploads/tinymce', $filename);

        // Return file URL for TinyMCE
        return response()->json([
            'location' => Storage::url($path)
        ]);
    }
}
