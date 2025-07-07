@extends('frontend.layouts.app')

@section('title', 'PPID - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-gray-600 to-gray-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        PPID
                    </h1>
                    <p class="opacity-90 text-xl">
                        Pejabat Pengelola Informasi dan Dokumentasi {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($ppid->count() > 0)
                    <div class="mx-auto max-w-4xl">
                        @foreach ($ppid as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl mb-8 rounded-lg overflow-hidden transition-shadow duration-300">
                                <div class="p-8">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="font-bold text-gray-900 dark:text-white text-2xl md:text-3xl">
                                            {{ $item->judul }}
                                        </h2>
                                        <span
                                            class="inline-flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full font-medium text-gray-800 dark:text-gray-200 text-sm">
                                            {{ str_replace('_', ' ', ucwords($item->kategori, '_')) }}
                                        </span>
                                    </div>

                                    <div class="dark:prose-invert max-w-none prose prose-lg">
                                        {!! $item->konten !!}
                                    </div>

                                    @if ($item->media->where('collection_name', 'dokumen')->count() > 0)
                                        <div class="mt-6 pt-6 border-gray-200 dark:border-gray-700 border-t">
                                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                                                Dokumen Terkait
                                            </h3>
                                            <div class="space-y-2">
                                                @foreach ($item->media->where('collection_name', 'dokumen') as $dokumen)
                                                    <a href="{{ $dokumen->getUrl() }}" target="_blank"
                                                        class="flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 p-3 border border-gray-200 dark:border-gray-700 rounded-lg transition-colors duration-200">
                                                        <div class="flex items-center">
                                                            <svg class="mr-2 w-5 h-5 text-blue-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                            <span class="font-medium text-gray-900 dark:text-white text-sm">
                                                                {{ $dokumen->name }}
                                                            </span>
                                                        </div>
                                                        <span class="text-gray-500 dark:text-gray-400 text-xs">
                                                            {{ round($dokumen->size / 1024, 1) }} KB
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if ($item->kontak_person || $item->email_kontak || $item->telepon_kontak)
                                        <div class="mt-6 pt-6 border-gray-200 dark:border-gray-700 border-t">
                                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                                                Kontak Informasi
                                            </h3>
                                            <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                                                @if ($item->kontak_person)
                                                    <div class="flex items-center">
                                                        <svg class="mr-2 w-5 h-5 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <span class="text-gray-900 dark:text-white text-sm">
                                                            {{ $item->kontak_person }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if ($item->email_kontak)
                                                    <div class="flex items-center">
                                                        <svg class="mr-2 w-5 h-5 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                        <a href="mailto:{{ $item->email_kontak }}"
                                                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-300 dark:text-blue-400 text-sm">
                                                            {{ $item->email_kontak }}
                                                        </a>
                                                    </div>
                                                @endif

                                                @if ($item->telepon_kontak)
                                                    <div class="flex items-center">
                                                        <svg class="mr-2 w-5 h-5 text-gray-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <a href="tel:{{ $item->telepon_kontak }}"
                                                            class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-300 dark:text-blue-400 text-sm">
                                                            {{ $item->telepon_kontak }}
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Informasi PPID
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Informasi PPID sedang dalam tahap penyusunan
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
