@extends('frontend.layouts.app')

@section('title', 'Profil Desa - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-green-600 to-green-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Profil {{ $desa->nama }}
                    </h1>
                    <p class="opacity-90 text-xl">
                        Selamat datang di {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl">
                    {{-- Informasi Umum --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg mb-8 p-8 rounded-lg">
                        <h2 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                            Informasi Umum
                        </h2>

                        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                            <div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                    Nama {{ $desa->jenis }}
                                </h3>
                                <p class="mb-4 text-gray-600 dark:text-gray-300">
                                    {{ $desa->nama }}
                                </p>
                            </div>

                            <div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                    Jenis Wilayah
                                </h3>
                                <p class="mb-4 text-gray-600 dark:text-gray-300">
                                    {{ ucfirst($desa->jenis) }}
                                </p>
                            </div>

                            @if ($desa->kode_desa)
                                <div>
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                        Kode Desa
                                    </h3>
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ $desa->kode_desa }}
                                    </p>
                                </div>
                            @endif

                            @if ($desa->kode_kecamatan)
                                <div>
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                        Kode Kecamatan
                                    </h3>
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ $desa->kode_kecamatan }}
                                    </p>
                                </div>
                            @endif

                            @if ($desa->alamat)
                                <div class="md:col-span-2">
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                        Alamat
                                    </h3>
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ $desa->alamat }}
                                    </p>
                                </div>
                            @endif

                            @if ($desa->deskripsi)
                                <div class="md:col-span-2">
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                        Deskripsi
                                    </h3>
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ $desa->deskripsi }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Navigasi ke Bagian Lain --}}
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                        <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'visi_misi']) }}"
                            class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                            <div
                                class="flex justify-center items-center bg-blue-100 dark:bg-blue-900 mx-auto mb-4 rounded-full w-16 h-16">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Visi & Misi
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Visi dan misi {{ $desa->nama }}
                            </p>
                        </a>

                        <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'sejarah']) }}"
                            class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                            <div
                                class="flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mb-4 rounded-full w-16 h-16">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Sejarah
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Sejarah {{ $desa->nama }}
                            </p>
                        </a>

                        <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'demografi']) }}"
                            class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                            <div
                                class="flex justify-center items-center bg-purple-100 dark:bg-purple-900 mx-auto mb-4 rounded-full w-16 h-16">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Demografi
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Data kependudukan
                            </p>
                        </a>

                        <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'struktur_organisasi']) }}"
                            class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                            <div
                                class="flex justify-center items-center bg-orange-100 dark:bg-orange-900 mx-auto mb-4 rounded-full w-16 h-16">
                                <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Struktur Organisasi
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                Struktur pemerintahan
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
