<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\ProfilDesaJenis;
use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    /**
     * Display the profil page for a specific desa.
     */
    public function show($uri, $jenis = 'tentang')
    {
        $desa = Desa::where('uri', $uri)->firstOrFail();

        // Get all profil data for this desa
        $profil = ProfilDesa::where('desa_id', $desa->id)
            ->where('is_published', true)
            ->orderBy('urutan')
            ->get();

        // Get the currently requested profile type
        $currentProfile = $profil->where('jenis', ProfilDesaJenis::from($jenis))->first();

        // If no profiles exist at all, create temporary default ones for display
        if ($profil->isEmpty()) {
            $defaultProfiles = [
                ['jenis' => ProfilDesaJenis::TENTANG, 'judul' => 'Tentang Desa', 'konten' => 'Informasi tentang desa belum tersedia.'],
                ['jenis' => ProfilDesaJenis::VISI_MISI, 'judul' => 'Visi dan Misi', 'konten' => '<h3>Visi</h3><p>Visi desa belum tersedia.</p><h3>Misi</h3><p>Misi desa belum tersedia.</p>'],
                ['jenis' => ProfilDesaJenis::STRUKTUR, 'judul' => 'Struktur Organisasi', 'konten' => 'Struktur organisasi desa belum tersedia.'],
                ['jenis' => ProfilDesaJenis::MONOGRAFI, 'judul' => 'Monografi Desa', 'konten' => 'Data monografi desa belum tersedia.'],
            ];
            $profil = collect($defaultProfiles)->map(fn($p) => (object)$p);
            $currentProfile = $profil->where('jenis', ProfilDesaJenis::from($jenis))->first() ?? $profil->first();
        } elseif (!$currentProfile && $profil->isNotEmpty()) {
            // If the specific 'jenis' is not found, default to the first available profile
            $currentProfile = $profil->first();
        }

        // Extract different profile types for the view
        $tentang = $profil->where('jenis', ProfilDesaJenis::TENTANG)->first();
        $visiMisi = $profil->where('jenis', ProfilDesaJenis::VISI_MISI)->first();
        $struktur = $profil->where('jenis', ProfilDesaJenis::STRUKTUR)->first();
        // Monografi can have multiple entries, so it remains a collection
        $monografi = $profil->where('jenis', ProfilDesaJenis::MONOGRAFI);

        return view('frontend.profil', compact(
            'desa',
            'profil',
            'currentProfile',
            'jenis',
            'tentang',
            'visiMisi',
            'struktur',
            'monografi'
        ));
    }

    /**
     * Download a document from profil.
     */
    public function download(Request $request, $id)
    {
        $desa = $request->route('desa');

        if (!$desa) {
            abort(404, 'Desa tidak ditemukan');
        }

        $profil = ProfilDesa::where('desa_id', $desa->id)
            ->where('id', $id)
            ->where('is_published', true)
            ->firstOrFail();

        // For now, we'll just return a simple response
        // In a real implementation, you would serve the actual file
        return response()->json([
            'message' => 'Download fitur akan segera tersedia',
            'profil_id' => $profil->id,
            'desa' => $desa->nama_lengkap
        ]);
    }
}
