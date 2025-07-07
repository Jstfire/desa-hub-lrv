<?php

namespace App\Filament\Resources\VisitorResource\Widgets;

use App\Models\Desa;
use App\Models\Visitor;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class VisitorStats extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        $query = Visitor::query();

        // Filter by desa if user is not superadmin
        $isSuperAdmin = Role::where('name', 'superadmin')
            ->whereHas('users', function ($q) use ($user) {
                $q->where('model_id', $user->id);
            })
            ->exists();

        if (!$isSuperAdmin) {
            $desaIds = $user->ownedTeams->pluck('id')->merge(
                $user->teams->pluck('id')
            )->unique()->toArray();

            $query->whereIn('desa_id', $desaIds);
        }

        // Get visit counts
        $today = $query->clone()->whereDate('created_at', today())->count();
        $yesterday = $query->clone()->whereDate('created_at', today()->subDay())->count();

        $thisWeekStart = now()->startOfWeek();
        $thisWeekEnd = now()->endOfWeek();
        $thisWeek = $query->clone()->whereBetween('created_at', [$thisWeekStart, $thisWeekEnd])->count();

        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();
        $lastWeek = $query->clone()->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count();

        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();
        $thisMonth = $query->clone()->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();

        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        $lastMonth = $query->clone()->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();

        $total = $query->clone()->count();

        // Get top pages
        $topPages = $query->clone()
            ->select('halaman', DB::raw('count(*) as total'))
            ->groupBy('halaman')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $topPagesText = 'Halaman Populer: ';
        foreach ($topPages as $index => $page) {
            $topPagesText .= ($index > 0 ? ', ' : '') . $page->halaman . ' (' . $page->total . ')';
        }

        // Calculate trend percentages
        $todayTrend = $yesterday > 0 ? (($today - $yesterday) / $yesterday) * 100 : 0;
        $weekTrend = $lastWeek > 0 ? (($thisWeek - $lastWeek) / $lastWeek) * 100 : 0;
        $monthTrend = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;

        return [
            Stat::make('Hari Ini', $today)
                ->description($yesterday > 0 ? "Kemarin: $yesterday" : '')
                ->descriptionIcon($todayTrend > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($todayTrend > 0 ? 'success' : 'danger'),

            Stat::make('Minggu Ini', $thisWeek)
                ->description($lastWeek > 0 ? "Minggu Lalu: $lastWeek" : '')
                ->descriptionIcon($weekTrend > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($weekTrend > 0 ? 'success' : 'danger'),

            Stat::make('Bulan Ini', $thisMonth)
                ->description($lastMonth > 0 ? "Bulan Lalu: $lastMonth" : '')
                ->descriptionIcon($monthTrend > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthTrend > 0 ? 'success' : 'danger'),

            Stat::make('Total Kunjungan', $total)
                ->description($topPagesText)
                ->color('primary'),
        ];
    }
}
