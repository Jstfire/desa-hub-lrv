<x-mail::message>
    # Pengaduan Baru Diterima

    Halo Admin,

    Sebuah pengaduan baru telah diterima di sistem DesaHub.

    **Detail Pengaduan:**
    - **Judul:** {{ $pengaduan->judul }}
    - **Kategori:** {{ $pengaduan->kategori }}
    - **Nama Pelapor:** {{ $pengaduan->nama }}
    - **Kontak:** {{ $pengaduan->telepon }}
    - **Desa:** {{ $pengaduan->desa->nama }}
    - **Tanggal:** {{ $pengaduan->created_at->format('d F Y, H:i') }}

    **Deskripsi Pengaduan:**
    {{ $pengaduan->deskripsi }}

    @if ($pengaduan->lampiran)
        Pelapor juga melampirkan dokumen yang bisa diakses melalui link berikut:
        {{ $pengaduan->lampiran }}
    @endif

    <x-mail::button :url="url('dashboard/pengaduans/' . $pengaduan->id)">
        Lihat Detail Pengaduan
    </x-mail::button>

    Mohon untuk segera menindaklanjuti pengaduan ini.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
