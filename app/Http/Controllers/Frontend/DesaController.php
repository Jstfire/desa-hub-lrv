<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\Beranda;
use App\Models\Berita;
use App\Models\LayananPublik;
use App\Models\Publikasi;
use App\Models\DataSektoral;
use App\Models\Galeri;
use App\Models\Visitor;
use App\Models\Pengaduan;
use App\Models\Metadata;
use App\Models\ProfilDesa;
use App\Models\Ppid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DesaController extends Controller
{
    public function index()
    {
        $desas = Desa::where('is_active', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->orderBy('nama')
            ->get();

        return view('frontend.pilih-desa', compact('desas'));
    }

    public function beranda($uri)
    {
        $desa = $this->getDesaByUri($uri);

        // Record visitor
        $this->recordVisitor($desa);

        // Get beranda settings
        $beranda = $desa->beranda;

        // Get berita terbaru based on beranda settings
        $beritaLimit = $beranda && $beranda->show_berita ? $beranda->jumlah_berita : 6;
        $beritaTerbaru = Berita::where('desa_id', $desa->id)
            ->where('is_published', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->orderBy('published_at', 'desc')
            ->limit($beritaLimit)
            ->get();

        // Get berita utama (highlight)
        $beritaUtama = Berita::where('desa_id', $desa->id)
            ->where('is_published', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->where('is_highlight', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Get struktur organisasi from ProfilDesa
        $strukturOrganisasi = ProfilDesa::where('desa_id', $desa->id)
            ->where('jenis', 'struktur')
            ->where('is_published', 1)
            ->first();

        // Get galeri based on beranda settings
        $galeriLimit = $beranda && $beranda->show_galeri ? $beranda->jumlah_galeri : 8;
        $galeri = Galeri::where('desa_id', $desa->id)
            ->where('is_published', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->limit($galeriLimit)
            ->get();

        return view('frontend.beranda', compact('desa', 'beranda', 'beritaTerbaru', 'beritaUtama', 'strukturOrganisasi', 'galeri'));
    }

    public function berita($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $query = Berita::where('desa_id', $desa->id)
            ->where('is_published', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('judul', 'ILIKE', '%' . request('search') . '%')
                    ->orWhere('konten', 'ILIKE', '%' . request('search') . '%')
                    ->orWhere('excerpt', 'ILIKE', '%' . request('search') . '%');
            });
        }

        // Category filter
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Highlight filter
        if (request('highlight') !== null) {
            $query->where('is_highlight', request('highlight') ? 1 : 0);
        }

        // Date range filter
        if (request('dari') && request('sampai')) {
            $query->whereBetween('published_at', [request('dari'), request('sampai')]);
        }

        $berita = $query->orderBy('published_at', 'desc')->paginate(12);

        // Preserve query parameters in pagination links
        $berita->appends(request()->query());

        return view('frontend.berita.index', compact('desa', 'berita'));
    }

    public function showBerita($uri, $slug)
    {
        $desa = $this->getDesaByUri($uri);

        $berita = Berita::where('desa_id', $desa->id)
            ->where('slug', $slug)
            ->where('is_published', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->firstOrFail();

        // Increment view count using the correct column name (view_count)
        $berita->increment('view_count');

        // Get berita terkait
        $beritaTerkait = Berita::where('desa_id', $desa->id)
            ->where('is_published', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->where('id', '!=', $berita->id)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.berita.show', compact('desa', 'berita', 'beritaTerkait'));
    }

    public function layananPublik($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $layananPublik = LayananPublik::where('desa_id', $desa->id)
            ->where('is_active', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->orderBy('nama')
            ->paginate(12);

        return view('frontend.layanan-publik', compact('desa', 'layananPublik'));
    }

    public function profil($uri)
    {
        $desa = $this->getDesaByUri($uri);

        // Get profil desa data
        $tentang = ProfilDesa::where('desa_id', $desa->id)
            ->where('jenis', 'tentang')
            ->where('is_published', true)
            ->first();

        $visiMisi = ProfilDesa::where('desa_id', $desa->id)
            ->where('jenis', 'visi_misi')
            ->where('is_published', true)
            ->first();

        $struktur = ProfilDesa::where('desa_id', $desa->id)
            ->where('jenis', 'struktur')
            ->where('is_published', true)
            ->first();

        $monografi = ProfilDesa::where('desa_id', $desa->id)
            ->where('jenis', 'monografi')
            ->where('is_published', true)
            ->orderBy('urutan')
            ->get();

        return view('frontend.profil', compact('desa', 'tentang', 'visiMisi', 'struktur', 'monografi'));
    }

    public function publikasi($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $query = Publikasi::where('desa_id', $desa->id)
            ->where('is_published', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where('judul', 'ILIKE', '%' . request('search') . '%');
        }

        // Category filter
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Year filter
        if (request('tahun')) {
            $query->whereYear('published_at', request('tahun'));
        }

        $publikasi = $query->orderBy('published_at', 'desc')->paginate(12);

        // Preserve query parameters in pagination links
        $publikasi->appends(request()->query());

        return view('frontend.publikasi', compact('desa', 'publikasi'));
    }

    public function dataSektoral($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $query = DataSektoral::where('desa_id', $desa->id)
            ->where('is_published', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where('judul', 'ILIKE', '%' . request('search') . '%');
        }

        // Category filter
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Year filter
        if (request('tahun')) {
            $query->whereYear('published_at', request('tahun'));
        }

        $dataSektoral = $query->orderBy('published_at', 'desc')->paginate(12);

        // Preserve query parameters in pagination links
        $dataSektoral->appends(request()->query());

        return view('frontend.data-sektoral', compact('desa', 'dataSektoral'));
    }

    public function metadata($uri, $jenis = null)
    {
        $desa = $this->getDesaByUri($uri);

        $query = Metadata::where('desa_id', $desa->id)
            ->where('is_active', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('judul', 'ILIKE', '%' . request('search') . '%')
                    ->orWhere('konten', 'ILIKE', '%' . request('search') . '%');
            });
        }

        // Type filter from route parameter
        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        // Type filter from query parameter (takes precedence)
        if (request('jenis')) {
            $query->where('jenis', request('jenis'));
            $jenis = request('jenis'); // Update the $jenis variable for the view
        }

        $metadata = $query->orderBy('urutan')->get();

        return view('frontend.metadata', compact('desa', 'metadata', 'jenis'));
    }

    public function ppid($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $query = Ppid::where('desa_id', $desa->id)
            ->where('is_active', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('judul', 'ILIKE', '%' . request('search') . '%')
                    ->orWhere('konten', 'ILIKE', '%' . request('search') . '%');
            });
        }

        // Category filter
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        $ppid = $query->orderBy('urutan')->get();

        return view('frontend.ppid', compact('desa', 'ppid'));
    }

    public function galeri($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $query = Galeri::where('desa_id', $desa->id)
            ->where('is_published', 1); // Use 1 instead of true for PostgreSQL compatibility

        // Search filter
        if (request('search')) {
            $query->where('judul', 'ILIKE', '%' . request('search') . '%');
        }

        // Type filter (foto/video)
        if (request('jenis')) {
            $query->where('jenis', request('jenis'));
        }

        // Year filter
        if (request('tahun')) {
            $query->whereYear('published_at', request('tahun'));
        }

        $galeri = $query->orderBy('published_at', 'desc')->paginate(24);

        // Preserve query parameters in pagination links
        $galeri->appends(request()->query());

        return view('frontend.galeri', compact('desa', 'galeri'));
    }

    public function pengaduan($uri)
    {
        $desa = $this->getDesaByUri($uri);

        return view('frontend.pengaduan', compact('desa'));
    }

    public function storePengaduan(Request $request, $uri)
    {
        $desa = $this->getDesaByUri($uri);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|url',
        ]);

        // Log the validated data for debugging
        Log::info('Validated pengaduan data:', $validated);

        // Ensure email is not empty
        if (empty($validated['email'])) {
            Log::error('Email is empty after validation');
            return redirect()->back()->with('error', 'Email wajib diisi.');
        }

        $pengaduanData = [
            'desa_id' => $desa->id,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'] ?? null,
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'status' => 'baru',
            'is_public' => 0, // Using 0 instead of false for PostgreSQL compatibility
        ];

        // Log the data being sent to create
        Log::info('Pengaduan data before create:', $pengaduanData);

        try {
            $pengaduan = Pengaduan::create($pengaduanData);
            Log::info('Pengaduan created successfully with ID: ' . $pengaduan->id);
        } catch (\Exception $e) {
            Log::error('Error creating pengaduan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.');
        }

        return redirect()->back()->with('success', 'Pengaduan Anda berhasil dikirim. Terima kasih!');
    }

    public function visitor($uri)
    {
        $desa = $this->getDesaByUri($uri);

        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        $thisWeek = now()->startOfWeek();
        $lastWeek = now()->subWeek()->startOfWeek();
        $thisMonth = now()->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();

        $stats = [
            'today' => Visitor::where('desa_id', $desa->id)
                ->whereDate('created_at', $today)
                ->count(),
            'yesterday' => Visitor::where('desa_id', $desa->id)
                ->whereDate('created_at', $yesterday)
                ->count(),
            'week' => Visitor::where('desa_id', $desa->id)
                ->where('created_at', '>=', $thisWeek)
                ->count(),
            'lastWeek' => Visitor::where('desa_id', $desa->id)
                ->whereBetween('created_at', [$lastWeek, $thisWeek])
                ->count(),
            'month' => Visitor::where('desa_id', $desa->id)
                ->where('created_at', '>=', $thisMonth)
                ->count(),
            'lastMonth' => Visitor::where('desa_id', $desa->id)
                ->whereBetween('created_at', [$lastMonth, $thisMonth])
                ->count(),
            'total' => Visitor::where('desa_id', $desa->id)->count(),
        ];

        return response()->json($stats);
    }

    private function getDesaByUri($uri)
    {
        return Desa::where('uri', $uri)
            ->where('is_active', 1) // Use 1 instead of true for PostgreSQL compatibility
            ->firstOrFail();
    }

    private function recordVisitor($desa)
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();

        // Check if visitor already recorded today
        $existingVisitor = Visitor::where('desa_id', $desa->id)
            ->where('ip_address', $ip)
            ->whereDate('created_at', now()->toDateString())
            ->first();

        if (!$existingVisitor) {
            Visitor::create([
                'desa_id' => $desa->id,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'halaman' => request()->path(), // Add the required halaman field
                'referrer' => request()->header('referer'),
            ]);
        }
    }
}
