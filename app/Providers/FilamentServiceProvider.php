<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Blade;
use Filament\Navigation\NavigationGroup;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class FilamentServiceProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('superadmin')
            ->path('dashboard')  // Menggunakan /dashboard sebagai path panel Filament
            ->login(false)  // Menonaktifkan login Filament, hanya mengandalkan Jetstream
            ->colors([
                'primary' => '#10b981', // Emerald-500
                'danger' => '#ef4444', // Red-500
                'success' => '#22c55e', // Green-500
                'warning' => '#f59e0b', // Amber-500
                'info' => '#3b82f6', // Blue-500
            ])
            ->font('Inter')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
            ])
            ->default()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                \App\Http\Middleware\EnsureUserHasFilamentAccess::class,
                Authenticate::class,
            ])
            ->authGuard('web') // Usar el mismo guard que Jetstream para compartir la autenticación
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Administrador')
                    ->icon('heroicon-o-cog')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Manajemen Desa')
                    ->icon('heroicon-o-home')
                    ->collapsed(),
                NavigationGroup::make()
                    ->label('Configuración')
                    ->icon('heroicon-o-adjustments')
                    ->collapsed(),
            ])
            ->brandName('DesaHub')
            ->darkMode(true)
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                'panels::scripts.after',
                fn(): string => Blade::render("
                    @vite(['resources/js/filament-init.js'])
                    <script>
                        // This script ensures sidebar functions are properly set up for Filament
                        document.addEventListener('alpine:initialized', () => {
                            if (window.Alpine && window.Alpine.store) {
                                // Ensure sidebar functions are available with both naming conventions
                                const sidebar = window.Alpine.store('sidebar');
                                if (sidebar) {
                                    if (typeof sidebar.isGroupCollapsed !== 'function') {
                                        sidebar.isGroupCollapsed = function(group) {
                                            return this.collapsedGroups[group] ?? false;
                                        };
                                    }
                                    
                                    if (typeof sidebar.groupIsCollapsed !== 'function') {
                                        sidebar.groupIsCollapsed = function(group) {
                                            return this.collapsedGroups[group] ?? false;
                                        };
                                    }
                                    
                                    if (typeof sidebar.toggleCollapsed !== 'function') {
                                        sidebar.toggleCollapsed = function(group) {
                                            this.collapsedGroups[group] = !this.collapsedGroups[group];
                                        };
                                    }
                                    
                                    if (typeof sidebar.toggleCollapsedGroup !== 'function') {
                                        sidebar.toggleCollapsedGroup = function(group) {
                                            this.collapsedGroups[group] = !this.collapsedGroups[group];
                                        };
                                    }
                                }
                                }
                            }
                        });
                    </script>
                ")
            )
            ->viteTheme('resources/css/filament/superadmin/theme.css');
    }
}
