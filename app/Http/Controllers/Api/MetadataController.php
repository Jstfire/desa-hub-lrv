<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MetadataController extends Controller
{
    public function trackDownload(Request $request, Metadata $metadata): JsonResponse
    {
        try {
            // Increment download count
            $metadata->increment('download_count');

            return response()->json([
                'success' => true,
                'message' => 'Download tracked successfully',
                'download_count' => $metadata->download_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track download'
            ], 500);
        }
    }
}