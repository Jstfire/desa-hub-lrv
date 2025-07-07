@extends('frontend.desa.layouts.main')

@section('title', 'Publikasi - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-gray-900 dark:text-white text-3xl">
                Publikasi {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Dokumen dan publikasi resmi {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-gray-800 shadow-sm mb-8 p-4 rounded-lg">
            <form action="{{ route('desa.publikasi', $desa->uri) }}" method="GET" class="flex flex-wrap gap-4">
                <div class="w-full md:w-auto">
                    <label for="search"
                        class="block mb-1 font-medium text-gray-700 dark:text-gray-300 text-sm">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari publikasi..."
                        class="block dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:ring focus:ring-primary-500 w-full dark:text-white">
                </div>

                <div class="w-full md:w-auto">
                    <label for="kategori"
                        class="block mb-1 font-medium text-gray-700 dark:text-gray-300 text-sm">Kategori</label>
                    <select id="kategori" name="kategori"
                        class="block dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:ring focus:ring-primary-500 w-full dark:text-white">
                        <option value="">Semua Kategori</option>
                        <option value="laporan_keuangan" {{ request('kategori') == 'laporan_keuangan' ? 'selected' : '' }}>
                            Laporan Keuangan</option>
                        <option value="laporan_kegiatan" {{ request('kategori') == 'laporan_kegiatan' ? 'selected' : '' }}>
                            Laporan Kegiatan</option>
                        <option value="rencana_kerja" {{ request('kategori') == 'rencana_kerja' ? 'selected' : '' }}>Rencana
                            Kerja</option>
                        <option value="peraturan_desa" {{ request('kategori') == 'peraturan_desa' ? 'selected' : '' }}>
                            Peraturan Desa</option>
                        <option value="transparansi" {{ request('kategori') == 'transparansi' ? 'selected' : '' }}>
                            Transparansi</option>
                        <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <label for="tahun"
                        class="block mb-1 font-medium text-gray-700 dark:text-gray-300 text-sm">Tahun</label>
                    <select id="tahun" name="tahun"
                        class="block dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:ring focus:ring-primary-500 w-full dark:text-white">
                        <option value="">Semua Tahun</option>
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-end w-full md:w-auto">
                    <button type="submit"
                        class="bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md text-white">Filter</button>
                    @if (request('search') || request('kategori') || request('tahun'))
                        <a href="{{ route('desa.publikasi', $desa->uri) }}"
                            class="bg-gray-500 hover:bg-gray-600 ml-2 px-4 py-2 rounded-md text-white">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Layout Toggle -->
        <div class="flex justify-end mb-6">
            <div class="flex space-x-2">
                <button id="grid-view" class="bg-gray-200 dark:bg-gray-700 p-2 rounded-md" aria-label="Tampilan Grid">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
                <button id="list-view" class="p-2 rounded-md" aria-label="Tampilan List">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Grid View (Default) -->
        <div id="grid-container" class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($publikasi as $item)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg overflow-hidden transition-shadow">
                    <div class="relative bg-gray-200 dark:bg-gray-700 h-48">
                        @if ($item->getFirstMediaUrl('thumbnail'))
                            <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex justify-center items-center w-full h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="top-0 right-0 absolute mt-2 mr-2">
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                            {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                            {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                            {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                            {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                            {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                            {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                            text-white">
                                {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                            {{ $item->judul }}
                        </h3>

                        <div class="flex items-center mb-4 text-gray-500 dark:text-gray-400 text-sm">
                            <span>{{ $item->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->tahun }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->download_count }} unduhan</span>
                        </div>

                        @if ($item->deskripsi)
                            <p class="mb-4 text-gray-600 dark:text-gray-300 line-clamp-3">
                                {{ Str::limit($item->deskripsi, 150) }}
                            </p>
                        @endif

                        <a href="{{ route('desa.publikasi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                            class="inline-flex items-center bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh Dokumen
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mb-1 font-medium text-gray-500 dark:text-gray-400 text-xl">Tidak ada publikasi</h3>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada dokumen publikasi yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- List View (Hidden by Default) -->
        <div id="list-container" class="hidden space-y-4">
            @forelse($publikasi as $item)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg overflow-hidden transition-shadow">
                    <div class="flex md:flex-row flex-col">
                        <div class="relative bg-gray-200 dark:bg-gray-700 md:w-1/4 h-48 md:h-auto">
                            @if ($item->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex justify-center items-center w-full h-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="md:hidden top-0 left-0 absolute mt-2 ml-2">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                                {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                                {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                                {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                                {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                                {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                                {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                                text-white">
                                    {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 md:w-3/4">
                            <div class="hidden md:block mb-2">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                                {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                                {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                                {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                                {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                                {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                                {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                                text-white">
                                    {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                                </span>
                            </div>

                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                                {{ $item->judul }}
                            </h3>

                            <div class="flex items-center mb-4 text-gray-500 dark:text-gray-400 text-sm">
                                <span>{{ $item->published_at->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item->tahun }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item->download_count }} unduhan</span>
                            </div>

                            @if ($item->deskripsi)
                                <p class="mb-4 text-gray-600 dark:text-gray-300">
                                    {{ Str::limit($item->deskripsi, 250) }}
                                </p>
                            @endif

                            <a href="{{ route('desa.publikasi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                                class="inline-flex items-center bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mb-1 font-medium text-gray-500 dark:text-gray-400 text-xl">Tidak ada publikasi</h3>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada dokumen publikasi yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $publikasi->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('head')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gridViewBtn = document.getElementById('grid-view');
            const listViewBtn = document.getElementById('list-view');
            const gridContainer = document.getElementById('grid-container');
            const listContainer = document.getElementById('list-container');

            // Set active view from localStorage or default to grid
            const activeView = localStorage.getItem('publikasi-view') || 'grid';
            setActiveView(activeView);

            // Grid View Button
            gridViewBtn.addEventListener('click', function() {
                setActiveView('grid');
            });

            // List View Button
            listViewBtn.addEventListener('click', function() {
                setActiveView('list');
            });

            function setActiveView(view) {
                if (view === 'grid') {
                    gridContainer.classList.remove('hidden');
                    listContainer.classList.add('hidden');
                    gridViewBtn.classList.add('bg-gray-200', 'dark:bg-gray-700');
                    listViewBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                } else {
                    gridContainer.classList.add('hidden');
                    listContainer.classList.remove('hidden');
                    gridViewBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                    listViewBtn.classList.add('bg-gray-200', 'dark:bg-gray-700');
                }

                // Save preference
                localStorage.setItem('publikasi-view', view);
            }
        });
    </script>
@endpush
