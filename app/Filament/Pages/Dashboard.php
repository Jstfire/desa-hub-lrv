<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = '/';

    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getHeading(): string
    {
        $user = Auth::user();
        $greeting = $this->getGreeting();

        return $greeting . ', ' . $user->name . '!';
    }

    public function getSubheading(): ?string
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('name')->toArray();

        if (in_array('superadmin', $roles)) {
            return 'Selamat datang di panel Super Administrator DesaHub';
        } elseif (in_array('admin_desa', $roles)) {
            return 'Selamat datang di panel Administrator Desa';
        } elseif (in_array('operator_desa', $roles)) {
            return 'Selamat datang di panel Operator Desa';
        }

        return 'Selamat datang di DesaHub';
    }

    private function getGreeting(): string
    {
        $hour = now()->hour;

        if ($hour < 10) {
            return 'Selamat pagi';
        } elseif ($hour < 15) {
            return 'Selamat siang';
        } elseif ($hour < 19) {
            return 'Selamat sore';
        } else {
            return 'Selamat malam';
        }
    }
}
