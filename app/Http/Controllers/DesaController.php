<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Desa;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DesaController extends Controller
{
    /**
     * Inisialisasi controller
     */
    public function __construct()
    {
        // Konstruktor
    }

    /**
     * Middleware untuk mengecek keberadaan desa berdasarkan URI
     */
    private function checkDesa($uri)
    {
        // Cek apakah desa dengan URI tersebut ada
        $desa = Desa::where('uri', $uri)
            ->where('is_active', true)
            ->first();

        if (!$desa) {
            abort(404, 'Desa atau kelurahan tidak ditemukan.');
        }

        return $desa;
    }

    /**
     * Menampilkan halaman beranda desa
     */
    public function index($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $beritaTerbaru = Berita::where('desa_id', $desa->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.desa.index', [
            'desa' => $desa,
            'beritaTerbaru' => $beritaTerbaru,
        ]);
    }

    /**
     * Menampilkan halaman berita desa
     */
    public function berita($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $berita = Berita::where('desa_id', $desa->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.desa.berita.index', [
            'desa' => $desa,
            'berita' => $berita,
        ]);
    }

    /**
     * Menampilkan detail berita
     */
    public function beritaDetail($uri, $slug)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $berita = Berita::where('desa_id', $desa->id)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $berita->increment('view_count');

        // Get related posts
        $related = Berita::where('desa_id', $desa->id)
            ->where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.desa.berita.show', [
            'desa' => $desa,
            'berita' => $berita,
            'related' => $related,
        ]);
    }

    /**
     * Menampilkan halaman layanan publik
     */
    public function layananPublik($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);
        $layanan = $desa->layananPublik()
            ->where('is_active', true)
            ->orderBy('urutan')
            ->paginate(12);

        return view('frontend.desa.layanan-publik', [
            'desa' => $desa,
            'layanan' => $layanan,
        ]);
    }

    /**
     * Menampilkan halaman profil desa
     */
    public function profil($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);
        $metadata = $desa->metadata()
            ->where('jenis', 'profil')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('frontend.desa.profil', [
            'desa' => $desa,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Menampilkan halaman publikasi desa
     */
    public function publikasi($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $query = $desa->publikasi()
            ->where('is_published', true);

        // Filter berdasarkan pencarian
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        // Filter berdasarkan tahun
        if (request('tahun')) {
            $query->where('tahun', request('tahun'));
        }

        // Urutkan berdasarkan tanggal publikasi terbaru
        $publikasi = $query->latest('published_at')
            ->paginate(12);

        return view('frontend.desa.publikasi.index', [
            'desa' => $desa,
            'publikasi' => $publikasi,
        ]);
    }
    /**
     * Menampilkan halaman data sektoral
     */
    public function dataSektoral($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $query = $desa->dataSektoral()
            ->where('is_published', true);

        // Filter berdasarkan pencarian
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan sektor
        if (request('sektor')) {
            $query->where('sektor', request('sektor'));
        }

        // Filter berdasarkan tahun
        if (request('tahun')) {
            $query->where('tahun', request('tahun'));
        }

        // Urutkan berdasarkan tanggal publikasi terbaru
        $data = $query->latest('published_at')
            ->paginate(12);

        return view('frontend.desa.data-sektoral.index', [
            'desa' => $desa,
            'data' => $data,
        ]);
    }

    /**
     * Menampilkan halaman detail data sektoral
     */
    public function dataSektoralDetail($uri, $slug)
    {
        $desa = $this->checkDesa($uri);

        $data = $desa->dataSektoral()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view counter
        $data->increment('view_count');

        $this->recordVisit(request(), $desa);

        return view('frontend.desa.data-sektoral.show', [
            'desa' => $desa,
            'data' => $data,
        ]);
    }

    /**
     * Menampilkan halaman metadata statistik
     */
    public function metadata($uri, $jenis = null)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        if ($jenis) {
            $metadata = $desa->metadata()
                ->where('jenis', $jenis)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->paginate(12);

            return view('frontend.desa.metadata.jenis', [
                'desa' => $desa,
                'metadata' => $metadata,
                'jenis' => $jenis,
            ]);
        }

        // Halaman index metadata
        return view('frontend.desa.metadata.index', [
            'desa' => $desa,
        ]);
    }

    /**
     * Menampilkan halaman PPID
     */
    public function ppid($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $ppid = $desa->ppid()
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.desa.ppid.index', [
            'desa' => $desa,
            'ppid' => $ppid,
        ]);
    }

    /**
     * Menampilkan halaman galeri
     */
    public function galeri($uri, $jenis = null)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $query = $desa->galeri()
            ->where('is_published', true)
            ->latest('published_at');

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        $galeri = $query->paginate(24);

        return view('frontend.desa.galeri.index', [
            'desa' => $desa,
            'galeri' => $galeri,
            'jenis' => $jenis,
        ]);
    }

    /**
     * Menampilkan formulir pengaduan
     */
    public function pengaduan($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        return view('frontend.desa.pengaduan.form', [
            'desa' => $desa,
        ]);
    }

    /**
     * Menyimpan pengaduan
     */
    public function storePengaduan(Request $request, $uri)
    {
        $desa = $this->checkDesa($uri);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|url',
        ]);

        $pengaduan = $desa->pengaduan()->create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'status' => 'baru',
        ]);

        if (isset($validated['lampiran'])) {
            $pengaduan->update(['lampiran' => $validated['lampiran']]);
        }

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dikirim. Kami akan segera memprosesnya.'
            ]);
        }

        return redirect()->back()->with('success', 'Pengaduan berhasil dikirim. Kami akan segera memprosesnya.');
    }

    /**
     * Download publikasi file dan tambahkan counter
     */
    public function downloadPublikasi($uri, $id)
    {
        $desa = $this->checkDesa($uri);
        $publikasi = $desa->publikasi()->findOrFail($id);

        // Increment download counter
        $publikasi->increment('download_count');

        // Get the file from media library
        $media = $publikasi->getFirstMedia('dokumen');

        if (!$media) {
            return back()->with('error', 'File tidak ditemukan');
        }

        // Return the download response
        return response()->download($media->getPath(), $publikasi->judul . '.' . $media->extension);
    }

    /**
     * Download PPID file dan tambahkan counter
     */
    public function downloadPpid($uri, $id)
    {
        $desa = $this->checkDesa($uri);
        $ppid = $desa->ppid()->findOrFail($id);

        // Increment download counter
        $ppid->increment('download_count');

        // Get the file from media library
        $media = $ppid->getFirstMedia('dokumen');

        if (!$media) {
            return back()->with('error', 'File tidak ditemukan');
        }

        // Return the download response
        return response()->download($media->getPath(), $ppid->judul . '.' . $media->extension);
    }

    /**
     * Download Monografi file dan tambahkan counter
     */
    public function downloadMonografi($uri, $id)
    {
        $desa = $this->checkDesa($uri);
        $monografi = $desa->metadata()->where('jenis', 'monografi')->findOrFail($id);

        // Increment download counter
        $monografi->increment('download_count');

        // Get the media file
        $media = $monografi->getFirstMedia('monografi');

        if (!$media) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($media->getPath(), $monografi->judul . '.' . $media->extension);
    }

    /**
     * Mencatat kunjungan ke desa
     */
    private function recordVisit(Request $request, Desa $desa)
    {
        Visitor::create([
            'desa_id' => $desa->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'halaman' => $request->path(),
            'referrer' => $request->header('referer'),
        ]);
    }

    /**
     * Menampilkan statistik pengunjung
     */
    public function statistik($uri)
    {
        $desa = $this->checkDesa($uri);
        $this->recordVisit(request(), $desa);

        $stats = [
            'today' => $desa->visitors()->whereDate('created_at', today())->count(),
            'yesterday' => $desa->visitors()->whereDate('created_at', today()->subDay())->count(),
            'this_week' => $desa->visitors()->whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'last_week' => $desa->visitors()->whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek()
            ])->count(),
            'this_month' => $desa->visitors()->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'last_month' => $desa->visitors()->whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)->count(),
            'total' => $desa->visitors()->count(),
        ];

        return view('frontend.desa.statistik', [
            'desa' => $desa,
            'stats' => $stats,
        ]);
    }
}
