<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataSektoral;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DataSektoralController extends Controller
{
    public function trackView(Request $request, DataSektoral $dataSektoral): JsonResponse
    {
        try {
            // Increment view count
            $dataSektoral->increment('view_count');

            return response()->json([
                'success' => true,
                'message' => 'View tracked successfully',
                'view_count' => $dataSektoral->view_count
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track view'
            ], 500);
        }
    }
}
