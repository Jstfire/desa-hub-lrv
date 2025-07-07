<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex flex-col items-center">
                <x-authentication-card-logo />
                <h2 class="mt-4 font-bold text-gray-800 text-2xl">Registrasi Diblokir</h2>
                <p class="mt-2 text-gray-600 text-sm">Sistem Web Desa Terintegrasi</p>
            </div>
        </x-slot>

        <div class="mb-4 text-center">
            <div class="bg-red-100 px-4 py-3 border border-red-400 rounded text-red-700">
                <strong>Akses Ditolak!</strong>
                <p class="mt-2">Registrasi tidak diizinkan. Sistem ini khusus untuk admin yang sudah ditentukan.</p>
            </div>
        </div>

        <div class="text-center">
            <div class="text-gray-600 text-sm">
                <p>Jika Anda adalah admin yang berwenang, silakan login dengan kredensial yang telah diberikan.</p>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}"
                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 active:bg-blue-900 disabled:opacity-25 px-4 py-2 border border-transparent focus:border-blue-900 rounded-md focus:outline-none focus:ring ring-blue-300 font-semibold text-white text-xs uppercase tracking-widest transition">
                {{ __('Kembali ke Login') }}
            </a>
        </div>

        <div class="mt-4 text-center">
            <div class="text-gray-500 text-xs">
                <p><strong>Sistem khusus untuk admin. Kredensial tersedia:</strong></p>
                <p><strong>SuperAdmin:</strong> superadmin@mail.com / password</p>
                <p><strong>Admin Desa:</strong> admin@mail.id / password</p>
                <p><strong>Operator:</strong> operator@mail.id / password</p>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
