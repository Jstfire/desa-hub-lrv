<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Desa;
use App\Models\Berita;
use App\Models\LayananPublik;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return [
                Stat::make('Total Desa', Desa::count())
                    ->description('Jumlah desa yang terdaftar')
                    ->descriptionIcon('heroicon-o-home')
                    ->color('success'),
                Stat::make('Total Pengguna', User::count())
                    ->description('Jumlah pengguna sistem')
                    ->descriptionIcon('heroicon-o-users')
                    ->color('primary'),
                Stat::make('Total Berita', Berita::count())
                    ->description('Jumlah berita yang dipublikasikan')
                    ->descriptionIcon('heroicon-o-newspaper')
                    ->color('warning'),
                Stat::make('Layanan Publik', LayananPublik::count())
                    ->description('Jumlah layanan publik aktif')
                    ->descriptionIcon('heroicon-o-clipboard-document-list')
                    ->color('info'),
            ];
        }

        if ($user->hasRole(['admin_desa', 'operator_desa'])) {
            $userDesaIds = Desa::where('admin_id', $user->getKey())->pluck('id');

            return [
                Stat::make('Desa Anda', $userDesaIds->count())
                    ->description('Jumlah desa yang Anda kelola')
                    ->descriptionIcon('heroicon-o-home')
                    ->color('success'),
                Stat::make('Berita Anda', Berita::whereIn('desa_id', $userDesaIds)->count())
                    ->description('Jumlah berita yang Anda buat')
                    ->descriptionIcon('heroicon-o-newspaper')
                    ->color('warning'),
                Stat::make('Layanan Publik', LayananPublik::whereIn('desa_id', $userDesaIds)->count())
                    ->description('Jumlah layanan publik aktif')
                    ->descriptionIcon('heroicon-o-clipboard-document-list')
                    ->color('info'),
                Stat::make('Berita Terpublikasi', Berita::whereIn('desa_id', $userDesaIds)->where('is_published', true)->count())
                    ->description('Berita yang sudah dipublikasikan')
                    ->descriptionIcon('heroicon-o-check-circle')
                    ->color('primary'),
            ];
        }

        return [];
    }
}
