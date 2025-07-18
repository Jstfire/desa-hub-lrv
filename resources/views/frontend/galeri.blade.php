@extends('frontend.layouts.app')

@section('title', 'Galeri - ' . $desa->nama_lengkap)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-pink-600 to-pink-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Galeri
                    </h1>
                    <p class="opacity-90 text-xl">
                        Dokumentasi kegiatan dan keindahan {{ $desa->nama_lengkap }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Search and Filter Section --}}
        <section class="bg-gray-50 dark:bg-gray-800 py-8">
            <div class="mx-auto px-4 container">
                <div class="bg-white dark:bg-gray-900 shadow-lg p-6 rounded-lg">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-4">
                        {{-- Search --}}
                        <div class="md:col-span-2">
                            <label for="search" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Cari Galeri
                            </label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berdasarkan judul..."
                                    class="dark:bg-gray-700 px-4 py-2 pr-10 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-pink-500 w-full dark:text-white">
                                <div class="right-0 absolute inset-y-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Type Filter --}}
                        <div>
                            <label for="jenis" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Jenis Media
                            </label>
                            <select id="jenis" name="jenis"
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-pink-500 w-full dark:text-white">
                                <option value="">Semua Jenis</option>
                                <option value="foto" {{ request('jenis') == 'foto' ? 'selected' : '' }}>
                                    Foto</option>
                                <option value="video" {{ request('jenis') == 'video' ? 'selected' : '' }}>
                                    Video</option>
                            </select>
                        </div>

                        {{-- Year Filter --}}
                        <div>
                            <label for="tahun" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Tahun
                            </label>
                            <select id="tahun" name="tahun"
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-pink-500 w-full dark:text-white">
                                <option value="">Semua Tahun</option>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Filter Buttons --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button onclick="applyFilters()"
                            class="bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
                            <svg class="inline-block mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            Terapkan Filter
                        </button>
                        <button onclick="resetFilters()"
                            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
                            <svg class="inline-block mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                {{-- Results Info --}}
                @if (request()->hasAny(['search', 'jenis', 'tahun']))
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            Menampilkan {{ $galeri->total() }} hasil
                            @if (request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('jenis'))
                                dengan jenis "<strong>{{ ucfirst(request('jenis')) }}</strong>"
                            @endif
                            @if (request('tahun'))
                                untuk tahun "<strong>{{ request('tahun') }}</strong>"
                            @endif
                        </p>
                    </div>
                @endif

                @if ($galeri->count() > 0)
                    <!-- Masonry Grid Layout -->
                    <div class="masonry-grid">
                        @foreach ($galeri as $item)
                            @php
                                $imageUrl = $item->getFirstMediaUrl('foto');
                            @endphp
                            <div class="group bg-white shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-all duration-300 cursor-pointer masonry-item"
                                onclick="openGalleryModal('{{ $imageUrl }}', '{{ addslashes($item->judul) }}', '{{ addslashes($item->deskripsi ?? '') }}', '{{ $item->published_at ? $item->published_at->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : '') }}', '{{ ucfirst($item->jenis) }}', '{{ $item->kategori ?? '' }}', '{{ $item->user ? $item->user->name : '' }}', '{{ $item->view_count }}')">
                                <div class="relative overflow-hidden">
                                    @if ($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $item->judul }}"
                                            class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="flex justify-center items-center bg-gray-200 w-full h-64">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $galeri->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Galeri
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Galeri foto dan video akan segera tersedia
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>

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

    <style>
        /* Horizontal Masonry Grid CSS */
        .masonry-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .masonry-item {
            flex: 1 1 100%;
            min-width: 0;
        }

        @media (min-width: 640px) {
            .masonry-item {
                flex: 1 1 calc(50% - 0.75rem);
            }
        }

        @media (min-width: 768px) {
            .masonry-item {
                flex: 1 1 calc(33.333% - 1rem);
            }
        }

        @media (min-width: 1024px) {
            .masonry-item {
                flex: 1 1 calc(25% - 1.125rem);
            }
        }

        @media (min-width: 1280px) {
            .masonry-item {
                flex: 1 1 calc(20% - 1.2rem);
            }
        }

        /* Ensure images maintain aspect ratio */
        .masonry-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Modal styles */
        #galleryModal {
            backdrop-filter: blur(4px);
        }

        #modalImage {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>

    <script>
        function applyFilters() {
            const search = document.getElementById('search').value;
            const jenis = document.getElementById('jenis').value;
            const tahun = document.getElementById('tahun').value;

            const params = new URLSearchParams(window.location.search);

            if (search) params.set('search', search);
            else params.delete('search');

            if (jenis) params.set('jenis', jenis);
            else params.delete('jenis');

            if (tahun) params.set('tahun', tahun);
            else params.delete('tahun');

            window.location.search = params.toString();
        }

        function resetFilters() {
            window.location.href = window.location.pathname;
        }

        // Apply filters on Enter key
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        // Auto-apply filters on select change
        document.getElementById('jenis').addEventListener('change', applyFilters);
        document.getElementById('tahun').addEventListener('change', applyFilters);
    </script>

    @push('scripts')
        @vite('resources/js/gallery.js')
    @endpush

@endsection
