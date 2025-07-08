@extends('frontend.layouts.app')

@section('title', 'Pilih Desa - DesaHub')

@section('content')
    <div class="bg-gradient-to-br from-green-50 dark:from-gray-900 to-blue-50 dark:to-gray-800 min-h-screen">
        {{-- Header Section --}}
        <section class="py-20">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <div class="mb-8">
                        <h1 class="mb-4 font-bold text-gray-900 dark:text-white text-4xl md:text-6xl">
                            Selamat Datang di
                            <span class="bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 text-transparent">
                                DesaHub
                            </span>
                        </h1>
                        <p class="mx-auto max-w-2xl text-gray-600 dark:text-gray-300 text-xl">
                            Platform terintegrasi untuk layanan dan informasi desa di Kabupaten Buton Selatan
                        </p>
                    </div>

                    <div class="mb-12">
                        <div
                            class="inline-flex items-center space-x-2 bg-white dark:bg-gray-800 shadow-md px-6 py-3 rounded-full">
                            <x-heroicon-o-map-pin class="w-5 h-5 text-green-600" />
                            <span class="font-medium text-gray-900 dark:text-white">
                                Pilih desa/kelurahan untuk mengakses layanan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Desa Selection Section --}}
        <section class="pb-20">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-6xl">
                    @if ($desas->count() > 0)
                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($desas as $desa)
                                <a href="/{{ $desa->uri }}"
                                    class="group block bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 border border-gray-200 dark:border-gray-700 rounded-xl transition-all hover:-translate-y-1 duration-300 transform">
                                    <div class="flex items-start space-x-4">
                                        <div class="bg-gradient-to-br from-green-500 to-green-600 shadow-lg p-3 rounded-lg">
                                            @if ($desa->jenis === 'desa')
                                                <x-heroicon-o-home class="w-8 h-8 text-white" />
                                            @else
                                                <x-heroicon-o-building-office class="w-8 h-8 text-white" />
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <h3
                                                class="mb-2 font-bold text-gray-900 dark:group-hover:text-green-400 dark:text-white group-hover:text-green-600 text-xl transition-colors">
                                                {{ $desa->nama }}
                                            </h3>
                                            <p class="mb-3 text-gray-600 dark:text-gray-300 text-sm">
                                                {{ ucfirst($desa->jenis) }}
                                                @if ($desa->kode_desa)
                                                    • Kode: {{ $desa->kode_desa }}
                                                @endif
                                            </p>

                                            @if ($desa->deskripsi)
                                                <p class="mb-4 text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                                    {{ Str::limit($desa->deskripsi, 100) }}
                                                </p>
                                            @endif

                                            <div class="flex justify-between items-center">
                                                <div
                                                    class="inline-flex items-center space-x-1 text-green-600 dark:text-green-400 text-sm">
                                                    <x-heroicon-o-globe-alt class="w-4 h-4" />
                                                    <span>/{{ $desa->uri }}</span>
                                                </div>

                                                <div
                                                    class="inline-flex items-center space-x-1 text-green-600 dark:text-green-400 text-sm transition-transform group-hover:translate-x-1">
                                                    <span>Kunjungi</span>
                                                    <x-heroicon-o-arrow-right class="w-4 h-4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 shadow-lg p-12 rounded-xl text-center">
                            <div class="mb-6">
                                <x-heroicon-o-map class="mx-auto w-16 h-16 text-gray-400" />
                            </div>
                            <h3 class="mb-4 font-bold text-gray-900 dark:text-white text-2xl">
                                Belum Ada Desa Terdaftar
                            </h3>
                            <p class="mx-auto mb-8 max-w-md text-gray-600 dark:text-gray-300">
                                Saat ini belum ada desa atau kelurahan yang terdaftar dalam sistem DesaHub.
                            </p>
                            <a href="/dashboard"
                                class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-medium text-white transition-colors">
                                <x-heroicon-o-plus class="w-5 h-5" />
                                <span>Tambah Desa</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="bg-white dark:bg-gray-800 py-16">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 text-center">
                        <h2 class="mb-4 font-bold text-gray-900 dark:text-white text-3xl">
                            Fitur Unggulan DesaHub
                        </h2>
                        <p class="mx-auto max-w-2xl text-gray-600 dark:text-gray-300">
                            Platform terintegrasi yang menyediakan berbagai layanan dan informasi untuk kemudahan masyarakat
                        </p>
                    </div>

                    <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                        <div class="text-center">
                            <div
                                class="flex justify-center items-center bg-blue-100 dark:bg-blue-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                <x-heroicon-o-newspaper class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                Berita Desa
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Informasi terkini dari desa
                            </p>
                        </div>

                        <div class="text-center">
                            <div
                                class="flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-green-600 dark:text-green-400" />
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                Layanan Publik
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Akses mudah ke layanan desa
                            </p>
                        </div>

                        <div class="text-center">
                            <div
                                class="flex justify-center items-center bg-purple-100 dark:bg-purple-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                <x-heroicon-o-document-text class="w-8 h-8 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                Publikasi
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Dokumen dan laporan resmi
                            </p>
                        </div>

                        <div class="text-center">
                            <div
                                class="flex justify-center items-center bg-orange-100 dark:bg-orange-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                <x-heroicon-o-chat-bubble-left-ellipsis
                                    class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                Pengaduan
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Sampaikan aspirasi Anda
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
<span
    class="px-3 py-1 text-sm rounded-full {{ $desa->jenis == 'desa' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
    {{ ucfirst($desa->jenis) }}
</span>
</div>

@if ($desa->deskripsi)
    <p class="mb-4 text-gray-600 line-clamp-3">
        {{ Str::limit($desa->deskripsi, 100) }}
    </p>
@endif

@if ($desa->alamat)
    <div class="flex items-center mb-4 text-gray-500">
        <i class="mr-2 fas fa-map-marker-alt"></i>
        <span class="text-sm">{{ $desa->alamat }}</span>
    </div>
@endif

<div class="flex justify-between items-center">
    <div class="flex items-center text-gray-500">
        <i class="mr-2 fas fa-link"></i>
        <span class="font-mono text-sm">{{ $desa->uri }}</span>
    </div>
    <a href="/{{ $desa->uri }}"
        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white transition-colors duration-200">
        <span>Kunjungi</span>
        <i class="fa-arrow-right ml-2 fas"></i>
    </a>
</div>
</div>
</div>
@endforeach
</div>

@if ($desas->isEmpty())
    <div class="py-12 text-center">
        <i class="mb-4 text-gray-400 text-6xl fas fa-info-circle"></i>
        <h3 class="mb-2 font-semibold text-gray-600 text-xl">Belum Ada Desa Terdaftar</h3>
        <p class="text-gray-500">Tidak ada desa yang tersedia saat ini.</p>
    </div>
@endif
</div>

<footer class="bg-gray-800 mt-12 text-white">
    <div class="mx-auto px-4 py-6 container">
        <div class="text-center">
            <p>&copy; 2025 DesaHub. Made with <i class="text-red-500 fas fa-heart"></i> by Jstfire.</p>
        </div>
    </div>
</footer>
</body>

</html>
