<x-mail::message>
    # Anda Ditunjuk Sebagai Admin Desa

    Halo {{ $user->name }},

    Selamat! Anda telah ditunjuk sebagai **Admin** untuk **{{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }}
    {{ $desa->nama_lengkap }}**.

    @if ($password)
        **Detail Akun Baru Anda:**
        - Nama: {{ $user->name }}
        - Email: {{ $user->email }}
        - Password: {{ $password }}

        Untuk keamanan, segera ubah password Anda setelah login.
    @else
        Anda dapat menggunakan akun yang sudah ada untuk mengelola desa ini.
    @endif

    Sebagai admin desa, Anda memiliki akses untuk mengelola berbagai fitur di sistem DesaHub:
    - Kelola operator
    - Kelola beranda desa
    - Kelola berita
    - Kelola layanan publik
    - Kelola profil desa
    - Kelola publikasi
    - Kelola data sektoral
    - Kelola metadata statistik
    - Kelola footer
    - Kelola pengaduan
    - Pantau statistik pengunjung

    <x-mail::button :url="url('login')">
        Login Sekarang
    </x-mail::button>

    Jika Anda memiliki pertanyaan tentang peran dan tanggung jawab Anda, silakan hubungi superadmin sistem.

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
