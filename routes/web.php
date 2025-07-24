<?php

use App\Http\Controllers\Frontend\DesaController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;

// Ruta raíz que redirige - pilih desa
Route::get('/', [DesaController::class, 'index'])->name('home');



// Rutas para panel de control (dashboard)
// Dashboard adalah panel Filament untuk admin roles - dihandle langsung oleh Filament
// Middleware validasi sudah ada di FilamentServiceProvider (EnsureUserHasFilamentAccess)

// Blokir akses registrasi - sistem khusus untuk admin
Route::get('/register', function () {
    return view('auth.register-blocked');
});

Route::post('/register', function () {
    return redirect()->route('login')->withErrors([
        'email' => 'Registrasi tidak diizinkan. Sistem ini khusus untuk admin yang sudah ditentukan.'
    ]);
});

// Rutas para frontend desa
Route::prefix('{uri}')->group(function () {
    // Beranda desa
    Route::get('/', [DesaController::class, 'beranda'])->name('desa.beranda');

    // Berita
    Route::get('/berita', [DesaController::class, 'berita'])->name('desa.berita');
    Route::get('/berita/{slug}', [DesaController::class, 'showBerita'])->name('desa.berita.show');

    // Layanan Publik
    Route::get('/layanan-publik', [DesaController::class, 'layananPublik'])->name('desa.layanan-publik');

    // Profil Desa
    Route::get('/profil/{jenis?}', [\App\Http\Controllers\Frontend\ProfilDesaController::class, 'show'])->name('desa.profil');
    Route::get('/profil/dokumen/{id}/download', [\App\Http\Controllers\Frontend\ProfilDesaController::class, 'download'])->name('desa.profil.dokumen.download');

    // Publikasi
    Route::get('/publikasi', [DesaController::class, 'publikasi'])->name('desa.publikasi');

    // Data Sektoral
    Route::get('/data-sektoral', [DesaController::class, 'dataSektoral'])->name('desa.data-sektoral');

    // Metadata Statistik
    Route::get('/metadata', [DesaController::class, 'metadata'])->name('desa.metadata');
    Route::get('/metadata/{jenis}', [DesaController::class, 'metadata'])->name('desa.metadata.jenis');

    // PPID
    Route::get('/ppid', [DesaController::class, 'ppid'])->name('desa.ppid');
    Route::get('/ppid/{id}/preview', [DesaController::class, 'ppidPreview'])->name('desa.ppid.preview');

    // Publikasi Preview
    Route::get('/publikasi/{id}/preview', [DesaController::class, 'publikasiPreview'])->name('desa.publikasi.preview');

    // Metadata Preview
    Route::get('/metadata/{id}/preview', [DesaController::class, 'metadataPreview'])->name('desa.metadata.preview');

    // Data Sektoral Preview
    Route::get('/data-sektoral/{id}/preview', [DesaController::class, 'dataSektoralPreview'])->name('desa.data-sektoral.preview');

    // Galeri
    Route::get('/galeri', [DesaController::class, 'galeri'])->name('desa.galeri');

    // Pengaduan
    Route::get('/pengaduan', [DesaController::class, 'pengaduan'])->name('desa.pengaduan');
    Route::post('/pengaduan', [DesaController::class, 'storePengaduan'])->name('desa.pengaduan.store');

    // Statistik Pengunjung API
    Route::get('/api/visitor-stats', [DesaController::class, 'visitor'])->name('desa.visitor.stats');

    // API untuk increment download count publikasi
    Route::post('/api/publikasi/{id}/download', function ($uri, $id) {
        $publikasi = \App\Models\Publikasi::findOrFail($id);
        $publikasi->increment('download_count');
        return response()->json(['success' => true]);
    })->name('desa.publikasi.download');

    // API untuk increment view count data sektoral
    Route::post('/api/data-sektoral/{id}/view', function ($uri, $id) {
        $dataSektoral = \App\Models\DataSektoral::findOrFail($id);
        $dataSektoral->increment('view_count');
        return response()->json(['success' => true]);
    })->name('desa.data-sektoral.view');
});

// Temporary test route to check the hasRole method
Route::get('/test-role', function () {
    $user = App\Models\User::find(1);
    if ($user) {
        return $user->hasRole('superadmin') ? 'Has role' : 'Does not have role';
    }
    return 'User not found';
});
