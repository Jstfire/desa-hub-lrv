<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ppid;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PpidController extends Controller
{
    public function trackDownload(Request $request, Ppid $ppid): JsonResponse
    {
        try {
            // Increment download count
            $ppid->increment('download_count');

            return response()->json([
                'success' => true,
                'message' => 'Download tracked successfully',
                'download_count' => $ppid->download_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track download'
            ], 500);
        }
    }
}