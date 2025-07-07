@extends('frontend.desa.layouts.main')

@section('title', 'Profil Desa - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="mb-8">
                <h1 class="font-bold text-gray-900 dark:text-white text-3xl">Profil {{ $desa->nama }}</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Informasi lengkap tentang {{ $desa->nama }}</p>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-8">
                <nav class="flex space-x-4 border-gray-200 dark:border-gray-700 border-b">
                    <button onclick="showTab('tentang')" id="tab-tentang"
                        class="px-4 py-2 border-b-2 border-blue-600 font-medium text-blue-600 text-sm tab-button">
                        Tentang Desa
                    </button>
                    <button onclick="showTab('struktur')" id="tab-struktur"
                        class="px-4 py-2 font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 dark:text-gray-400 text-sm tab-button">
                        Struktur Pemerintahan
                    </button>
                    <button onclick="showTab('monografi')" id="tab-monografi"
                        class="px-4 py-2 font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 dark:text-gray-400 text-sm tab-button">
                        Monografi Desa
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <!-- Tentang Desa Tab -->
            <div id="tentang-content" class="tab-content">
                @php
                    $tentang = $metadata->where('jenis', 'tentang')->first();
                    $visi = $metadata->where('jenis', 'visi')->first();
                    $misi = $metadata->where('jenis', 'misi')->first();
                @endphp

                <div class="gap-8 grid grid-cols-1 lg:grid-cols-2">
                    <!-- Tentang -->
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="flex items-center mb-4 font-semibold text-gray-900 dark:text-white text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-6 h-6 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Tentang {{ $desa->nama }}
                            </h2>
                            @if ($tentang && $tentang->deskripsi)
                                <div class="dark:prose-invert max-w-none prose">
                                    {!! $tentang->deskripsi !!}
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Informasi tentang desa belum tersedia.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Visi & Misi -->
                    <div class="space-y-6">
                        <!-- Visi -->
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="flex items-center mb-4 font-semibold text-gray-900 dark:text-white text-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-6 h-6 text-green-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Visi
                                </h2>
                                @if ($visi && $visi->deskripsi)
                                    <div class="dark:prose-invert max-w-none prose">
                                        {!! $visi->deskripsi !!}
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">Visi desa belum tersedia.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Misi -->
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="flex items-center mb-4 font-semibold text-gray-900 dark:text-white text-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-6 h-6 text-purple-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                    Misi
                                </h2>
                                @if ($misi && $misi->deskripsi)
                                    <div class="dark:prose-invert max-w-none prose">
                                        {!! $misi->deskripsi !!}
                                    </div>
                                @else
                                    <p class="text-gray-500 dark:text-gray-400">Misi desa belum tersedia.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Pemerintahan Tab -->
            <div id="struktur-content" class="hidden tab-content">
                @php
                    $struktur = $metadata->where('jenis', 'struktur')->first();
                @endphp

                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="flex items-center mb-6 font-semibold text-gray-900 dark:text-white text-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 w-8 h-8 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Struktur Pemerintahan {{ $desa->nama }}
                        </h2>

                        @if ($struktur && $struktur->deskripsi)
                            <div class="dark:prose-invert max-w-none prose">
                                {!! $struktur->deskripsi !!}
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-16 h-16 text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-gray-500 dark:text-gray-400">Struktur pemerintahan desa belum tersedia.
                                </p>
                            </div>
                        @endif

                        @if ($struktur && $struktur->getFirstMedia('struktur'))
                            <div class="mt-6">
                                <img src="{{ $struktur->getFirstMediaUrl('struktur') }}"
                                    alt="Struktur Pemerintahan {{ $desa->nama }}" class="shadow-lg rounded-lg w-full">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Monografi Desa Tab -->
            <div id="monografi-content" class="hidden tab-content">
                @php
                    $monografi = $metadata->where('jenis', 'monografi');
                @endphp

                <div class="mb-6">
                    <h2 class="mb-4 font-semibold text-gray-900 dark:text-white text-2xl">Monografi {{ $desa->nama }}</h2>

                    <!-- Search Bar -->
                    <div class="bg-white dark:bg-gray-800 shadow-md mb-6 p-4 rounded-lg">
                        <div class="flex md:flex-row flex-col gap-4">
                            <div class="flex-1">
                                <input type="text" id="monografi-search" placeholder="Cari dokumen monografi..."
                                    class="dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 dark:border-gray-600 focus:border-blue-500 rounded-md focus:ring focus:ring-blue-500 w-full dark:text-white">
                            </div>
                        </div>
                    </div>
                </div>

                @if ($monografi->count() > 0)
                    <!-- Pinterest-style Masonry Grid -->
                    <div class="gap-4 columns-1 md:columns-2 lg:columns-3">
                        @foreach ($monografi as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg mb-4 rounded-lg overflow-hidden break-inside-avoid monografi-item">
                                @if ($item->getFirstMedia('monografi'))
                                    <div class="relative">
                                        @php
                                            $media = $item->getFirstMedia('monografi');
                                        @endphp

                                        @if (in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/gif', 'image/webp']))
                                            <img src="{{ $media->getUrl() }}" alt="{{ $item->judul }}"
                                                class="w-full h-auto">
                                        @else
                                            <div
                                                class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 h-32">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        @endif

                                        <div
                                            class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-200">
                                            <a href="{{ route('desa.monografi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                                                class="bg-white hover:bg-gray-100 opacity-0 hover:opacity-100 shadow-lg p-2 rounded-full transition-opacity duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                        {{ $item->judul }}</h3>

                                    @if ($item->deskripsi)
                                        <p class="mb-3 text-gray-600 dark:text-gray-300 text-sm">{{ $item->deskripsi }}
                                        </p>
                                    @endif

                                    <div
                                        class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-xs">
                                        <span>{{ $item->created_at->format('d M Y') }}</span>
                                        <span>{{ $item->download_count }} unduhan</span>
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ route('desa.monografi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white text-sm transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Unduh
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-16 h-16 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-4 text-gray-500 dark:text-gray-400">Dokumen monografi desa belum tersedia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Tab functionality
            function showTab(tabName) {
                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active state from all tab buttons
                document.querySelectorAll('.tab-button').forEach(button => {
                    button.classList.remove('text-blue-600', 'border-blue-600', 'border-b-2');
                    button.classList.add('text-gray-500', 'dark:text-gray-400');
                });

                // Show selected tab content
                document.getElementById(tabName + '-content').classList.remove('hidden');

                // Add active state to selected tab button
                const activeButton = document.getElementById('tab-' + tabName);
                activeButton.classList.add('text-blue-600', 'border-blue-600', 'border-b-2');
                activeButton.classList.remove('text-gray-500', 'dark:text-gray-400');

                // Save tab preference
                localStorage.setItem('activeProfilTab', tabName);
            }

            // Load saved tab preference or default to tentang
            document.addEventListener('DOMContentLoaded', function() {
                const savedTab = localStorage.getItem('activeProfilTab') || 'tentang';
                showTab(savedTab);

                // Monografi search functionality
                const searchInput = document.getElementById('monografi-search');
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        const searchTerm = this.value.toLowerCase();
                        const items = document.querySelectorAll('.monografi-item');

                        items.forEach(item => {
                            const title = item.querySelector('h3').textContent.toLowerCase();
                            const description = item.querySelector('p') ? item.querySelector('p')
                                .textContent.toLowerCase() : '';

                            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
@endsection
