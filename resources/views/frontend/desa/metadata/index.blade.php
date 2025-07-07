@extends('frontend.desa.layouts.main')

@section('title', 'Metadata Statistik - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <h1 class="mb-8 font-bold text-gray-900 dark:text-white text-3xl">Metadata Statistik</h1>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
                <!-- Metadata Kegiatan -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="bg-blue-600 p-4">
                        <h2 class="font-semibold text-white text-xl">Metadata Kegiatan</h2>
                    </div>
                    <div class="p-6">
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            Metadata kegiatan berisi informasi tentang seluruh kegiatan statistik yang dilakukan oleh desa.
                        </p>
                        <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'kegiatan']) }}"
                            class="block bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded w-full font-semibold text-white text-center">
                            Lihat Metadata Kegiatan
                        </a>
                    </div>
                </div>

                <!-- Metadata Indikator -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="bg-green-600 p-4">
                        <h2 class="font-semibold text-white text-xl">Metadata Indikator</h2>
                    </div>
                    <div class="p-6">
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            Metadata indikator berisi informasi tentang indikator-indikator statistik yang digunakan dalam
                            pengukuran.
                        </p>
                        <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'indikator']) }}"
                            class="block bg-green-600 hover:bg-green-700 px-4 py-2 rounded w-full font-semibold text-white text-center">
                            Lihat Metadata Indikator
                        </a>
                    </div>
                </div>

                <!-- Metadata Variabel -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="bg-purple-600 p-4">
                        <h2 class="font-semibold text-white text-xl">Metadata Variabel</h2>
                    </div>
                    <div class="p-6">
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            Metadata variabel berisi informasi tentang variabel-variabel yang digunakan dalam kegiatan
                            statistik.
                        </p>
                        <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'variabel']) }}"
                            class="block bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded w-full font-semibold text-white text-center">
                            Lihat Metadata Variabel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
