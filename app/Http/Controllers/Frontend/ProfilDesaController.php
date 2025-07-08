<?php

namespace App\Http\Controllers\Frontend;

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
    public function show(Request $request, $jenis = 'tentang')
    {
        $desa = $request->route('desa');

        if (!$desa) {
            abort(404, 'Desa tidak ditemukan');
        }

        // Get all profil data for this desa
        $profil = ProfilDesa::where('desa_id', $desa->id)
            ->where('is_published', true)
            ->orderBy('urutan')
            ->get();

        // Get the currently requested profile type, or default to first available
        $currentProfile = ProfilDesa::where('desa_id', $desa->id)
            ->where('is_published', true)
            ->where('jenis', $jenis)
            ->first();

        if (!$profil) {
            // Create default profil data if none exists
            $defaultProfiles = [
                [
                    'desa_id' => $desa->id,
                    'jenis' => 'tentang',
                    'judul' => 'Tentang Desa',
                    'konten' => 'Informasi tentang desa belum tersedia.',
                    'urutan' => 1,
                    'is_published' => false
                ],
                [
                    'desa_id' => $desa->id,
                    'jenis' => 'visi_misi',
                    'judul' => 'Visi dan Misi',
                    'konten' => '<h3>Visi</h3><p>Visi desa belum tersedia.</p><h3>Misi</h3><p>Misi desa belum tersedia.</p>',
                    'urutan' => 2,
                    'is_published' => false
                ],
                [
                    'desa_id' => $desa->id,
                    'jenis' => 'struktur',
                    'judul' => 'Struktur Organisasi',
                    'konten' => 'Struktur organisasi desa belum tersedia.',
                    'urutan' => 3,
                    'is_published' => false
                ],
                [
                    'desa_id' => $desa->id,
                    'jenis' => 'monografi',
                    'judul' => 'Monografi Desa',
                    'konten' => 'Data monografi desa belum tersedia.',
                    'urutan' => 4,
                    'is_published' => false
                ]
            ];

            // Create temporary default profiles for display
            $profil = collect($defaultProfiles);
            $currentProfile = (object)$defaultProfiles[0];
        } else if (!$currentProfile && $profil->count() > 0) {
            // If specific jenis not found but other profiles exist, use the first one
            $currentProfile = $profil->first();
        }

        return view('frontend.profil', compact('desa', 'profil', 'currentProfile', 'jenis'));
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
            'desa' => $desa->nama
        ]);
    }
}
