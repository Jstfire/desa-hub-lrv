<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PublikasiController extends Controller
{
    public function trackDownload(Request $request, Publikasi $publikasi): JsonResponse
    {
        try {
            // Increment download count
            $publikasi->increment('download_count');

            return response()->json([
                'success' => true,
                'message' => 'Download tracked successfully',
                'download_count' => $publikasi->download_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track download'
            ], 500);
        }
    }
}
