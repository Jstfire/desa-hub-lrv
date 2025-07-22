@extends('frontend.layouts.app')

@section('title', $beranda ? $beranda->judul_welcome : 'Beranda')
@section('description', 'Selamat datang di situs resmi ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' .
    $desa->nama_lengkap)

@section('content')
    <!-- Section 1: Hero/Welcome Section -->
    <section class="relative bg-primary h-screen overflow-hidden text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        @if ($beranda && $beranda->getFirstMediaUrl('banner'))
            <div class="absolute inset-0">
                <img src="{{ $beranda->getFirstMediaUrl('banner') }}" alt="Banner" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
        @else
            <!-- Default gradient background if no banner -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary to-secondary"></div>
        @endif
        <div class="relative flex justify-center items-center mx-auto px-4 py-24 h-full text-center container">
            <div>
                <h1 class="mb-6 font-bold text-4xl md:text-6xl">
                    {!! $beranda && $beranda->judul_welcome
                        ? $beranda->judul_welcome
                        : 'Selamat Datang di<br>Situs Resmi ' . $desa->nama_lengkap !!}
                </h1>
                <div class="mx-auto mb-8 max-w-3xl text-xl md:text-2xl">
                    {!! $beranda && $beranda->deskripsi_welcome
                        ? $beranda->deskripsi_welcome
                        : 'Situs resmi ' .
                            ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') .
                            ' ' .
                            $desa->nama_lengkap .
                            ' yang menyediakan informasi lengkap tentang kegiatan, layanan, dan berita terkini.' !!}
                </div>
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
        </div>
    </section>

    <!-- Section 2: Berita Terbaru -->
    @if (!$beranda || $beranda->show_berita)
        <section class="bg-white dark:bg-gray-900 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">
                        {{ $beranda ? $beranda->judul_berita : 'Berita Terbaru' }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">Informasi terkini dan berita penting dari
                        {{ $desa->nama_lengkap }}</p>
                </div>

                @if ($beritaUtama->count() > 0)
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
                                        <span>{{ $berita->view_count ?? 0 }} views</span>
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
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                <div class="mb-4">
                    <i class="text-gray-400 text-6xl fas fa-newspaper"></i>
                </div>
                <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-lg">Belum ada berita yang tersedia
                </h3>
                <p class="text-gray-600 dark:text-gray-400">Berita terbaru akan ditampilkan di sini ketika sudah
                    tersedia.</p>
            </div>
    @endif

    <div class="mt-12 text-center">
        <a href="{{ route('desa.berita', $desa->uri) }}"
            class="bg-primary hover:bg-opacity-90 px-8 py-3 rounded-lg font-semibold text-white transition-colors">
            Lihat Semua Berita
        </a>
    </div>
    </div>
    </section>
@else
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="mx-auto px-4 container">
            <div class="bg-white dark:bg-gray-800 shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                <div class="mb-4">
                    <i class="text-gray-400 text-6xl fas fa-newspaper"></i>
                </div>
                <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-lg">Section berita tidak diaktifkan
                </h3>
                <p class="text-gray-600 dark:text-gray-400">Section berita belum diaktifkan atau belum ada berita yang
                    dipublikasikan.</p>
            </div>
        </div>
    </section>
    @endif

    <!-- Section 3: Lokasi Desa -->
    @if ($beranda && $beranda->show_lokasi)
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 text-3xl">
                        {{ $beranda->judul_lokasi ?? 'Lokasi Desa' }}
                    </h2>
                    <p class="mx-auto max-w-2xl text-gray-600">
                        Lokasi {{ $desa->nama_lengkap }}
                    </p>
                </div>

                @if ($beranda->embed_map)
                    <div class="mx-auto max-w-6xl">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            {!! $beranda->embed_map !!}
                        </div>
                    </div>
                @else
                    <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                        <div class="mb-4">
                            <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-gray-800 text-lg">Peta lokasi belum tersedia</h3>
                        <p class="text-gray-600">Peta lokasi akan ditampilkan di sini ketika sudah dikonfigurasi.</p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 text-lg">Peta lokasi belum tersedia</h3>
                    <p class="text-gray-600">Section lokasi belum diaktifkan atau belum dikonfigurasi.</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Section 4: Highlight Struktur Organisasi -->
    @if ($beranda && $beranda->show_struktur)
        <section class="bg-white py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 text-3xl">
                        {{ $beranda->judul_struktur ?? 'Struktur Organisasi' }}
                    </h2>
                    <p class="mx-auto max-w-2xl text-gray-600">
                        Struktur organisasi {{ $desa->nama_lengkap }}
                    </p>
                </div>

                @if ($strukturOrganisasi && $strukturOrganisasi->gambar)
                    <div class="mx-auto max-w-6xl">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $strukturOrganisasi->gambar) }}"
                                alt="Struktur Organisasi {{ $desa->nama_lengkap }}" class="w-full h-auto object-contain">
                        </div>
                        @if ($strukturOrganisasi->deskripsi)
                            <div class="mt-6 text-center">
                                <p class="text-gray-600">{{ $strukturOrganisasi->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                @elseif ($beranda->gambar_struktur)
                    <div class="mx-auto max-w-6xl">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $beranda->gambar_struktur) }}"
                                alt="Struktur Organisasi {{ $desa->nama }}" class="w-full h-auto object-contain">
                        </div>
                    </div>
                @else
                    <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                        <div class="mb-4">
                            <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-gray-800 text-lg">Struktur organisasi belum tersedia</h3>
                        <p class="text-gray-600">Struktur organisasi akan ditampilkan di sini ketika sudah tersedia.</p>
                    </div>
                @endif

                <div class="mt-12 text-center">
                    <a href="{{ route('desa.profil', $desa->uri) }}"
                        class="bg-primary hover:bg-primary-dark px-8 py-3 rounded-lg font-semibold text-white transition-colors">
                        Lihat Profil Lengkap
                    </a>
                </div>
            </div>
        </section>
    @else
        <section class="bg-white py-16">
            <div class="mx-auto px-4 container">
                <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 text-lg">Struktur organisasi belum tersedia</h3>
                    <p class="text-gray-600">Section struktur organisasi belum diaktifkan atau belum dikonfigurasi.</p>
                </div>
            </div>
        </section>
    @endif



    <!-- Section 5: Statistik Penduduk -->
    @if ($beranda && $beranda->show_penduduk)
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 text-3xl">
                        {{ $beranda->judul_penduduk ?? 'Statistik Penduduk' }}</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Data kependudukan terkini
                        {{ $desa->nama_lengkap }}</p>
                </div>

                @if ($beranda->total_penduduk || $beranda->penduduk_laki || $beranda->penduduk_perempuan)
                    <div class="gap-8 grid md:grid-cols-3">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 shadow-lg p-8 rounded-lg text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="mb-2 text-blue-100">Total Penduduk</p>
                                    <p class="font-bold text-3xl">{{ number_format($beranda->total_penduduk ?? 0) }}</p>
                                </div>
                                <div class="text-blue-200">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-green-500 to-green-600 shadow-lg p-8 rounded-lg text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="mb-2 text-green-100">Laki-laki</p>
                                    <p class="font-bold text-3xl">{{ number_format($beranda->penduduk_laki ?? 0) }}</p>
                                </div>
                                <div class="text-green-200">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-500 to-pink-600 shadow-lg p-8 rounded-lg text-white">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="mb-2 text-pink-100">Perempuan</p>
                                    <p class="font-bold text-3xl">{{ number_format($beranda->penduduk_perempuan ?? 0) }}
                                    </p>
                                </div>
                                <div class="text-pink-200">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($beranda->tanggal_data_penduduk)
                        <div class="mt-8 text-center">
                            <p class="text-gray-600">Data terakhir diperbarui:
                                {{ $beranda->tanggal_data_penduduk->format('d F Y') }}</p>
                        </div>
                    @endif
                @else
                    <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                        <div class="mb-4">
                            <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-gray-800 text-lg">Data statistik penduduk belum tersedia</h3>
                        <p class="text-gray-600">Data statistik penduduk akan ditampilkan di sini ketika sudah tersedia.
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 text-lg">Data statistik penduduk belum tersedia</h3>
                    <p class="text-gray-600">Section statistik penduduk belum diaktifkan atau belum dikonfigurasi.</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Section 6: APBDesa 2025 -->
    @if ($beranda && $beranda->show_apbdes)
        <section class="bg-white py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 text-3xl">
                        {{ $beranda->judul_apbdes ?? 'APBDesa 2025' }}</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Anggaran Pendapatan dan Belanja Desa tahun 2025</p>
                </div>

                @if ($beranda->pendapatan_desa || $beranda->belanja_desa)
                    <div class="gap-8 grid md:grid-cols-2">
                        <!-- Pendapatan Desa -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 shadow-lg p-8 rounded-lg">
                            <div class="flex items-center mb-6">
                                <div class="bg-green-500 mr-4 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-xl">Pendapatan Desa</h3>
                                    <p class="text-gray-600">Total pendapatan yang diterima</p>
                                </div>
                            </div>
                            <div class="mb-6">
                                <p class="font-bold text-green-600 text-3xl">
                                    Rp {{ number_format($beranda->pendapatan_desa ?? 0, 0, ',', '.') }}
                                </p>
                                @if ($beranda->target_pendapatan)
                                    <p class="mt-1 text-gray-600 text-sm">
                                        Target: Rp {{ number_format($beranda->target_pendapatan, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            @php
                                $targetPendapatan = $beranda->target_pendapatan ?? ($beranda->pendapatan_desa ?? 1);
                                $persentasePendapatan =
                                    $targetPendapatan > 0
                                        ? (($beranda->pendapatan_desa ?? 0) / $targetPendapatan) * 100
                                        : 0;
                            @endphp
                            <div class="mb-2">
                                <div class="flex justify-between mb-1 text-gray-600 text-sm">
                                    <span>Progress</span>
                                    <span>{{ number_format($persentasePendapatan, 1) }}%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-4">
                                    <div class="bg-gradient-to-r from-green-400 to-green-600 rounded-full h-4 transition-all duration-500"
                                        style="width: {{ min($persentasePendapatan, 100) }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Belanja Desa -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 shadow-lg p-8 rounded-lg">
                            <div class="flex items-center mb-6">
                                <div class="bg-blue-500 mr-4 p-3 rounded-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-xl">Belanja Desa</h3>
                                    <p class="text-gray-600">Total belanja yang dikeluarkan</p>
                                </div>
                            </div>
                            <div class="mb-6">
                                <p class="font-bold text-blue-600 text-3xl">
                                    Rp {{ number_format($beranda->belanja_desa ?? 0, 0, ',', '.') }}
                                </p>
                                @if ($beranda->target_belanja)
                                    <p class="mt-1 text-gray-600 text-sm">
                                        Target: Rp {{ number_format($beranda->target_belanja, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            @php
                                $targetBelanja = $beranda->target_belanja ?? ($beranda->pendapatan_desa ?? 1);
                                $persentaseBelanja =
                                    $targetBelanja > 0 ? (($beranda->belanja_desa ?? 0) / $targetBelanja) * 100 : 0;
                            @endphp
                            <div class="mb-2">
                                <div class="flex justify-between mb-1 text-gray-600 text-sm">
                                    <span>Progress</span>
                                    <span>{{ number_format($persentaseBelanja, 1) }}%</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-4">
                                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-full h-4 transition-all duration-500"
                                        style="width: {{ min($persentaseBelanja, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <p class="text-gray-600">Data APBDesa tahun 2025 - Transparansi anggaran desa</p>
                    </div>
                @else
                    <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                        <div class="mb-4">
                            <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-gray-800 text-lg">Data APBDesa belum tersedia</h3>
                        <p class="text-gray-600">Data anggaran pendapatan dan belanja desa akan ditampilkan di sini ketika
                            sudah tersedia.</p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="bg-white py-16">
            <div class="mx-auto px-4 container">
                <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 text-lg">Data APBDesa belum tersedia</h3>
                    <p class="text-gray-600">Section APBDesa belum diaktifkan atau belum dikonfigurasi.</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Section 7: Highlight Galeri Desa -->
    @if ($beranda && $beranda->show_galeri)
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="mb-12 text-center">
                    <h2 class="mb-4 font-bold text-gray-800 text-3xl">
                        {{ $beranda->judul_galeri ?? 'Galeri Desa' }}</h2>
                    <p class="mx-auto max-w-2xl text-gray-600">Dokumentasi kegiatan dan keindahan desa</p>
                </div>

                @if ($galeri && $galeri->count() > 0)
                    <div class="relative swiper-container gallery-carousel">
                        <div class="swiper-wrapper">
                            @foreach ($galeri->take($beranda->jumlah_galeri ?? 6) as $item)
                                @php
                                    $imageUrl =
                                        $item->getFirstMediaUrl('foto') ?:
                                        $item->getFirstMediaUrl('media') ?:
                                        $item->getFirstMediaUrl('thumbnail');
                                    // If no media found, use a placeholder
                                    if (empty($imageUrl)) {
                                        $imageUrl =
                                            'https://via.placeholder.com/400x533/e5e7eb/6b7280?text=' .
                                            urlencode($item->jenis === 'video' ? 'Video' : 'Foto');
                                    }
                                @endphp
                                <div class="group bg-white shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-all duration-300 cursor-pointer swiper-slide"
                                    onclick="openGalleryModal('{{ $imageUrl }}', '{{ addslashes($item->judul) }}', '{{ addslashes($item->deskripsi ?? '') }}', '{{ $item->published_at ? $item->published_at->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : '') }}', '{{ ucfirst($item->jenis) }}', '{{ $item->kategori ?? '' }}', '{{ $item->user ? $item->user->name : '' }}', '{{ $item->view_count }}')">
                                    <div class="relative aspect-[3/4] overflow-hidden">
                                        @if ($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $item->judul }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="flex justify-center items-center bg-gray-200 w-full h-full">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                        <!-- Overlay dengan informasi yang muncul saat hover -->
                                        <div
                                            class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 p-4 transition-all duration-300">
                                            <h3
                                                class="mb-1 font-semibold text-white text-lg transition-transform translate-y-4 group-hover:translate-y-0 duration-300 transform">
                                                {{ $item->judul }}</h3>
                                            <p
                                                class="text-white/90 text-sm leading-relaxed transition-transform translate-y-4 group-hover:translate-y-0 duration-300 delay-75 transform">
                                                {{ Str::limit($item->deskripsi ?? '', 80) }}</p>
                                            @if ($item->published_at || $item->created_at)
                                                <p
                                                    class="mt-2 text-white/80 text-xs transition-transform translate-y-4 group-hover:translate-y-0 duration-300 delay-100 transform">
                                                    <svg class="inline mr-1 w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>

                        <!-- Add Navigation -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <div class="mt-12 text-center">
                        <a href="{{ route('desa.galeri', $desa->uri) }}"
                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 hover:shadow-lg px-8 py-3 rounded-lg font-semibold text-white transition-all duration-300">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Lihat Semua Galeri
                        </a>
                    </div>
                @else
                    <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                        <div class="mb-4">
                            <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="mb-2 font-semibold text-gray-800 text-lg">Galeri belum tersedia</h3>
                        <p class="text-gray-600">Foto-foto kegiatan desa akan ditampilkan di sini ketika sudah tersedia.
                        </p>
                    </div>
                @endif
            </div>
        </section>
    @else
        <section class="bg-gray-50 py-16">
            <div class="mx-auto px-4 container">
                <div class="bg-white shadow-lg mx-auto p-8 rounded-lg max-w-md text-center">
                    <div class="mb-4">
                        <svg class="mx-auto w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 text-lg">Galeri belum tersedia</h3>
                    <p class="text-gray-600">Section galeri belum diaktifkan atau belum dikonfigurasi.</p>
                </div>
            </div>
        </section>
    @endif

    <!-- Modal Galeri -->
    <div id="galleryModal" class="hidden z-50 fixed inset-0 bg-black bg-opacity-75">
        <div class="flex justify-center items-center p-4 min-h-screen">
            <div class="relative bg-white shadow-xl rounded-lg w-full max-w-7xl max-h-[95vh] overflow-hidden">
                <!-- Tombol Close -->
                <button onclick="closeGalleryModal()"
                    class="top-4 right-4 z-20 absolute bg-black bg-opacity-50 hover:bg-opacity-75 p-2 rounded-full text-white transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <!-- Konten Modal -->
                <div class="flex lg:flex-row flex-col h-full max-h-[95vh]">
                    <!-- Container Gambar -->
                    <div class="group relative flex flex-1 justify-center items-center bg-gray-900">
                        <img id="modalImage" class="max-w-full max-h-full object-contain" alt="Gallery Image"
                            style="display: none;">
                        <div id="imageSpinner" class="absolute text-white">
                            <svg class="w-8 h-8 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>

                        <!-- Informasi Media saat hover -->
                        <div id="mediaInfo"
                            class="top-4 left-4 absolute bg-black bg-opacity-80 opacity-0 group-hover:opacity-100 p-3 rounded-lg text-white transition-opacity duration-300 pointer-events-none">
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span id="imageResolution">-</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span id="imageSize">-</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2">
                                        </path>
                                    </svg>
                                    <span id="imageFormat">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Informasi -->
                    <div class="bg-white p-6 w-full lg:w-96 overflow-y-auto">
                        <div class="mb-4">
                            <h3 id="modalTitle" class="mb-2 font-bold text-gray-800 text-2xl"></h3>
                            <div class="flex items-center gap-2 mb-3">
                                <span id="modalType"
                                    class="inline-flex items-center bg-blue-100 px-2.5 py-0.5 rounded-full font-medium text-blue-800 text-xs"></span>
                                <span id="modalCategory"
                                    class="inline-flex items-center bg-gray-100 px-2.5 py-0.5 rounded-full font-medium text-gray-800 text-xs"></span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h4 class="mb-2 font-semibold text-gray-700 text-sm">Deskripsi</h4>
                            <p id="modalDescription" class="text-gray-600 text-sm leading-relaxed"></p>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div id="modalDate" class="flex items-center text-gray-500">
                                <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="font-medium">Tanggal:</span>
                                <span id="modalDateText" class="ml-2"></span>
                            </div>

                            <div id="modalAuthor" class="flex items-center text-gray-500">
                                <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Dibuat oleh:</span>
                                <span id="modalAuthorText" class="ml-2"></span>
                            </div>

                            <div id="modalViews" class="flex items-center text-gray-500">
                                <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <span class="font-medium">Dilihat:</span>
                                <span id="modalViewsText" class="ml-2"></span>
                            </div>

                            <div id="modalSource" class="flex items-center text-gray-500">
                                <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                                <span class="font-medium">Sumber:</span>
                                <a id="modalSourceLink" href="#" target="_blank" rel="noopener noreferrer"
                                    class="ml-2 text-blue-600 hover:underline">Lihat Sumber</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        @vite('resources/js/gallery.js')
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var galleryCarousel = new Swiper('.gallery-carousel', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 4,
                            spaceBetween: 40,
                        },
                        1024: {
                            slidesPerView: 5,
                            spaceBetween: 50,
                        },
                    }
                });
            });
        </script>
    @endpush

@endsection
