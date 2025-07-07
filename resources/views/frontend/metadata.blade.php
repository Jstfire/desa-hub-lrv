@extends('frontend.layouts.app')

@section('title', 'Metadata - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-teal-600 to-teal-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        @if ($jenis)
                            {{ str_replace('_', ' ', ucwords($jenis, '_')) }}
                        @else
                            Metadata
                        @endif
                    </h1>
                    <p class="opacity-90 text-xl">
                        Informasi detail tentang {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($metadata->count() > 0)
                    <div class="mx-auto max-w-4xl">
                        @foreach ($metadata as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl mb-8 rounded-lg overflow-hidden transition-shadow duration-300">
                                @if ($item->getFirstMediaUrl('gambar'))
                                    <img src="{{ $item->getFirstMediaUrl('gambar') }}" alt="{{ $item->judul }}"
                                        class="w-full h-64 object-cover">
                                @endif

                                <div class="p-8">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="font-bold text-gray-900 dark:text-white text-2xl md:text-3xl">
                                            {{ $item->judul }}
                                        </h2>
                                        <span
                                            class="inline-flex items-center bg-teal-100 dark:bg-teal-900 px-3 py-1 rounded-full font-medium text-teal-800 dark:text-teal-200 text-sm">
                                            {{ str_replace('_', ' ', ucwords($item->jenis, '_')) }}
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
                            Belum Ada Metadata
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Informasi metadata sedang dalam tahap penyusunan
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
