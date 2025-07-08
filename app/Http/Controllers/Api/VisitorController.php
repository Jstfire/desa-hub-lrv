<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function getStats($uri): JsonResponse
    {
        try {
            $desa = Desa::where('uri', $uri)->firstOrFail();

            // Get today's stats
            $today = Visitor::where('desa_id', $desa->id)
                ->whereDate('visited_at', today())
                ->count();

            // Get this week's stats
            $thisWeek = Visitor::where('desa_id', $desa->id)
                ->whereBetween('visited_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])
                ->count();

            // Get this month's stats
            $thisMonth = Visitor::where('desa_id', $desa->id)
                ->whereMonth('visited_at', now()->month)
                ->whereYear('visited_at', now()->year)
                ->count();

            // Get total stats
            $total = Visitor::where('desa_id', $desa->id)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'today' => $today,
                    'this_week' => $thisWeek,
                    'this_month' => $thisMonth,
                    'total' => $total,
                    'desa' => $desa->nama
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get visitor stats'
            ], 500);
        }
    }

    public function track(Request $request, $uri): JsonResponse
    {
        try {
            $desa = Desa::where('uri', $uri)->firstOrFail();

            $visitor = new Visitor();
            $visitor->desa_id = $desa->id;
            $visitor->ip_address = $request->ip();
            $visitor->user_agent = $request->userAgent();
            $visitor->page_url = $request->input('page_url');
            $visitor->referrer = $request->header('referer');
            $visitor->visited_at = now();
            $visitor->save();

            return response()->json([
                'success' => true,
                'message' => 'Visitor tracked successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to track visitor'
            ], 500);
        }
    }
}
