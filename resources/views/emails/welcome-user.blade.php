<x-mail::message>
    # Selamat Datang di DesaHub!

    Halo {{ $user->name }},

    Terima kasih telah mendaftar di platform DesaHub. Akun Anda telah berhasil dibuat.

    **Detail Akun:**
    - Nama: {{ $user->name }}
    - Email: {{ $user->email }}

    @if ($user->desa)
        - Desa: {{ $user->desa->nama }}
        - Peran: {{ $user->roles->pluck('name')->implode(', ') }}
    @endif

    Silakan login menggunakan email dan password Anda untuk mengakses semua fitur yang tersedia sesuai dengan peran
    Anda.

    <x-mail::button :url="url('login')">
        Login Sekarang
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>
