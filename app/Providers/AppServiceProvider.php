<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Desa;
use App\Models\Pengaduan;
use App\Observers\UserObserver;
use App\Observers\DesaObserver;
use App\Observers\PengaduanObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for MySQL < 5.7.7 and MariaDB < 10.2.2
        Schema::defaultStringLength(191);

        // Register observers
        User::observe(UserObserver::class);
        Desa::observe(DesaObserver::class);
        Pengaduan::observe(PengaduanObserver::class);
    }
}
