<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Berita;
use App\Models\Desa;
use Illuminate\Support\Facades\Auth;

class LatestBeritaWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-berita-widget';

    protected int | string | array $columnSpan = 'full';

    public function getData()
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            $berita = Berita::with(['desa', 'user'])
                ->where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        } else {
            $userDesaIds = Desa::where('admin_id', $user->getKey())->pluck('id');
            $berita = Berita::with(['desa', 'user'])
                ->whereIn('desa_id', $userDesaIds)
                ->where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get();
        }

        return [
            'berita' => $berita
        ];
    }
}
