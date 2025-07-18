<x-mail::message>
    # Status Pengaduan Diperbarui

    Halo {{ $pengaduan->nama }},

    Status pengaduan Anda telah diperbarui.

    **Detail Pengaduan:**
    - **Judul:** {{ $pengaduan->judul }}
    - **Kategori:** {{ $pengaduan->kategori }}
    - **Desa:** {{ $pengaduan->desa->nama_lengkap }}
    - **Tanggal:** {{ $pengaduan->created_at->format('d F Y, H:i') }}

    **Perubahan Status:**
    - Status Sebelumnya: {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}
    - Status Saat Ini: {{ ucfirst(str_replace('_', ' ', $pengaduan->status)) }}

    @if ($pengaduan->status == 'resolved')
        Pengaduan Anda telah ditindaklanjuti dan diselesaikan oleh tim kami. Terima kasih atas partisipasi Anda dalam
        membangun desa yang lebih baik.
    @elseif($pengaduan->status == 'in_progress')
        Pengaduan Anda sedang dalam proses penanganan oleh tim kami. Kami akan memberikan informasi lebih lanjut jika
        ada perkembangan.
    @elseif($pengaduan->status == 'rejected')
        Mohon maaf, pengaduan Anda tidak dapat ditindaklanjuti karena alasan tertentu. Silakan hubungi kantor desa untuk
        informasi lebih lanjut.
    @endif

    @if ($pengaduan->keterangan)
        **Keterangan:**
        {{ $pengaduan->keterangan }}
    @endif

    Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kantor desa {{ $pengaduan->desa->nama_lengkap }}.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
