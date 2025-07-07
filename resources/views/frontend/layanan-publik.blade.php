@extends('frontend.layouts.app')

@section('title', 'Layanan Publik - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Layanan Publik
                    </h1>
                    <p class="opacity-90 text-xl">
                        Layanan publik yang disediakan oleh {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($layananPublik->count() > 0)
                    <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($layananPublik as $layanan)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow duration-300">
                                @if ($layanan->getFirstMediaUrl('thumbnail'))
                                    <img src="{{ $layanan->getFirstMediaUrl('thumbnail') }}" alt="{{ $layanan->nama }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-48">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                                        {{ $layanan->nama }}
                                    </h3>

                                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                                        {{ Str::limit($layanan->deskripsi, 100) }}
                                    </p>

                                    <div class="flex justify-between items-center">
                                        <span
                                            class="inline-flex items-center bg-blue-100 dark:bg-blue-900 px-3 py-1 rounded-full font-medium text-blue-800 dark:text-blue-200 text-sm">
                                            {{ $layanan->kategori }}
                                        </span>

                                        @if ($layanan->url)
                                            <a href="{{ $layanan->url }}" target="_blank"
                                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md font-medium text-white text-sm transition-colors duration-200">
                                                Akses Layanan
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">
                                                Segera Tersedia
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $layananPublik->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Layanan Publik
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Layanan publik sedang dalam tahap persiapan
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
