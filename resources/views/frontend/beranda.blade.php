@extends('frontend.layouts.app')

@section('title', 'Beranda')
@section('description', 'Selamat datang di situs resmi ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' .
    $desa->nama)

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-primary overflow-hidden text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative mx-auto px-4 py-24 text-center container">
            <h1 class="mb-6 font-bold text-4xl md:text-6xl">
                Selamat Datang di<br>
                {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="mx-auto mb-8 max-w-3xl text-xl md:text-2xl">
                Situs resmi {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
                yang menyediakan informasi lengkap tentang kegiatan, layanan, dan berita terkini.
            </p>
            <div class="flex sm:flex-row flex-col justify-center gap-4">
                <a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                    class="bg-white hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-primary transition-colors">
                    Layanan Publik
                </a>
                <a href="{{ route('desa.berita', $desa->uri) }}"
                    class="hover:bg-white px-8 py-3 border-2 border-white rounded-lg font-semibold text-white hover:text-primary transition-colors">
                    Berita Terbaru
                </a>
            </div>
        </div>
    </section>

    <!-- Berita Utama -->
    @if ($beritaUtama->count() > 0)
        <section class="bg-white dark:bg-gray-900 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Berita Utama</h2>
                    <p class="text-gray-600 dark:text-gray-400">Berita terpilih dan terkini dari {{ $desa->nama }}</p>
                </div>

                <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($beritaUtama as $berita)
                        <article
                            class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow">
                            @if ($berita->gambar_utama)
                                <img src="{{ asset('storage/' . $berita->gambar_utama) }}" alt="{{ $berita->judul }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-48">
                                    <i class="text-gray-400 text-4xl fas fa-image"></i>
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center mb-3 text-gray-500 dark:text-gray-400 text-sm">
                                    <i class="mr-2 fas fa-calendar"></i>
                                    <span>{{ $berita->tanggal_publikasi->format('d M Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="mr-2 fas fa-eye"></i>
                                    <span>{{ $berita->views ?? 0 }} views</span>
                                </div>

                                <h3 class="mb-3 font-bold text-gray-800 dark:text-white text-xl">
                                    <a href="{{ route('desa.berita.show', [$desa->uri, $berita->slug]) }}"
                                        class="hover:text-primary transition-colors">
                                        {{ $berita->judul }}
                                    </a>
                                </h3>

                                @if ($berita->excerpt)
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($berita->excerpt, 120) }}
                                    </p>
                                @endif

                                <a href="{{ route('desa.berita.show', [$desa->uri, $berita->slug]) }}"
                                    class="font-semibold text-primary hover:underline">
                                    Baca Selengkapnya <i class="fa-arrow-right ml-1 fas"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('desa.berita', $desa->uri) }}"
                        class="bg-primary hover:bg-opacity-90 px-8 py-3 rounded-lg font-semibold text-white transition-colors">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Layanan Publik -->
    @if ($layananPublik->count() > 0)
        <section class="bg-gray-50 dark:bg-gray-800 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Layanan Publik</h2>
                    <p class="text-gray-600 dark:text-gray-400">Akses mudah ke berbagai layanan publik</p>
                </div>

                <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($layananPublik as $layanan)
                        <div class="bg-white dark:bg-gray-900 shadow-lg hover:shadow-xl p-6 rounded-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div
                                    class="flex justify-center items-center bg-primary mr-4 rounded-lg w-12 h-12 text-white">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 dark:text-white text-lg">{{ $layanan->nama }}</h3>
                                </div>
                            </div>

                            @if ($layanan->deskripsi)
                                <p class="mb-4 text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($layanan->deskripsi, 100) }}
                                </p>
                            @endif

                            @if ($layanan->link)
                                <a href="{{ $layanan->link }}" target="_blank"
                                    class="font-semibold text-primary hover:underline">
                                    Akses Layanan <i class="ml-1 fas fa-external-link-alt"></i>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                        class="bg-secondary hover:bg-opacity-90 px-8 py-3 rounded-lg font-semibold text-white transition-colors">
                        Lihat Semua Layanan
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Statistik Desa -->
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="mx-auto px-4 container">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Statistik Desa</h2>
                <p class="text-gray-600 dark:text-gray-400">Data dan statistik terkini</p>
            </div>

            <div class="gap-8 grid grid-cols-1 md:grid-cols-4">
                <div class="text-center">
                    <div class="flex justify-center items-center bg-primary mx-auto mb-4 rounded-full w-20 h-20 text-white">
                        <i class="text-3xl fas fa-users"></i>
                    </div>
                    <h3 class="mb-2 font-bold text-gray-800 dark:text-white text-2xl">1,234</h3>
                    <p class="text-gray-600 dark:text-gray-400">Total Penduduk</p>
                </div>

                <div class="text-center">
                    <div
                        class="flex justify-center items-center bg-blue-500 mx-auto mb-4 rounded-full w-20 h-20 text-white">
                        <i class="text-3xl fas fa-male"></i>
                    </div>
                    <h3 class="mb-2 font-bold text-gray-800 dark:text-white text-2xl">623</h3>
                    <p class="text-gray-600 dark:text-gray-400">Laki-laki</p>
                </div>

                <div class="text-center">
                    <div
                        class="flex justify-center items-center bg-pink-500 mx-auto mb-4 rounded-full w-20 h-20 text-white">
                        <i class="text-3xl fas fa-female"></i>
                    </div>
                    <h3 class="mb-2 font-bold text-gray-800 dark:text-white text-2xl">611</h3>
                    <p class="text-gray-600 dark:text-gray-400">Perempuan</p>
                </div>

                <div class="text-center">
                    <div
                        class="flex justify-center items-center bg-green-500 mx-auto mb-4 rounded-full w-20 h-20 text-white">
                        <i class="text-3xl fas fa-home"></i>
                    </div>
                    <h3 class="mb-2 font-bold text-gray-800 dark:text-white text-2xl">345</h3>
                    <p class="text-gray-600 dark:text-gray-400">Kepala Keluarga</p>
                </div>
            </div>
        </div>
    </section>

    <!-- APBDesa -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="mx-auto px-4 container">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">APBDesa 2025</h2>
                <p class="text-gray-600 dark:text-gray-400">Anggaran Pendapatan dan Belanja Desa</p>
            </div>

            <div class="gap-8 grid grid-cols-1 md:grid-cols-2">
                <div class="bg-white dark:bg-gray-900 shadow-lg p-8 rounded-lg">
                    <h3 class="mb-6 font-bold text-gray-800 dark:text-white text-2xl">Pendapatan Desa</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Dana Desa</span>
                                <span class="font-semibold text-gray-800 dark:text-white">75%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-primary rounded-full h-2" style="width: 75%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">ADD</span>
                                <span class="font-semibold text-gray-800 dark:text-white">60%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-blue-500 rounded-full h-2" style="width: 60%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Lain-lain</span>
                                <span class="font-semibold text-gray-800 dark:text-white">45%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-green-500 rounded-full h-2" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-gray-200 dark:border-gray-700 border-t">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800 dark:text-white text-lg">Total</span>
                            <span class="font-bold text-primary text-2xl">Rp 850.000.000</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow-lg p-8 rounded-lg">
                    <h3 class="mb-6 font-bold text-gray-800 dark:text-white text-2xl">Belanja Desa</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Pembangunan</span>
                                <span class="font-semibold text-gray-800 dark:text-white">65%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-primary rounded-full h-2" style="width: 65%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Operasional</span>
                                <span class="font-semibold text-gray-800 dark:text-white">50%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-blue-500 rounded-full h-2" style="width: 50%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Pemberdayaan</span>
                                <span class="font-semibold text-gray-800 dark:text-white">40%</span>
                            </div>
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2">
                                <div class="bg-green-500 rounded-full h-2" style="width: 40%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-gray-200 dark:border-gray-700 border-t">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800 dark:text-white text-lg">Total</span>
                            <span class="font-bold text-secondary text-2xl">Rp 820.000.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Galeri -->
    @if ($galeri->count() > 0)
        <section class="bg-white dark:bg-gray-900 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Galeri Desa</h2>
                    <p class="text-gray-600 dark:text-gray-400">Dokumentasi kegiatan dan keindahan desa</p>
                </div>

                <div class="gap-4 grid grid-cols-2 md:grid-cols-4">
                    @foreach ($galeri as $item)
                        <div class="group relative shadow-lg rounded-lg overflow-hidden">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-48">
                                    <i class="text-gray-400 text-4xl fas fa-image"></i>
                                </div>
                            @endif

                            <div
                                class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="text-white text-center">
                                    <h4 class="mb-2 font-semibold">{{ $item->judul }}</h4>
                                    @if ($item->deskripsi)
                                        <p class="text-sm">{{ Str::limit($item->deskripsi, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('desa.galeri', $desa->uri) }}"
                        class="bg-primary hover:bg-opacity-90 px-8 py-3 rounded-lg font-semibold text-white transition-colors">
                        Lihat Semua Galeri
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Peta Lokasi -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="mx-auto px-4 container">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Lokasi Desa</h2>
                <p class="text-gray-600 dark:text-gray-400">Peta lokasi dan informasi geografis</p>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden">
                <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 h-96">
                    <div class="text-center">
                        <i class="mb-4 text-gray-400 text-6xl fas fa-map-marked-alt"></i>
                        <p class="text-gray-600 dark:text-gray-300">Peta akan ditampilkan di sini</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Integrasi dengan Google Maps</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
