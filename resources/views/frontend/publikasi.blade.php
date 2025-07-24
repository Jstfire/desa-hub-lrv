@extends('frontend.layouts.app')

@section('title', 'Publikasi - ' . $desa->nama_lengkap)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-purple-600 to-purple-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Publikasi
                    </h1>
                    <p class="opacity-90 text-xl">
                        Dokumen dan publikasi resmi {{ $desa->nama_lengkap }}
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
                                Cari Publikasi
                            </label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berdasarkan judul..."
                                    class="dark:bg-gray-700 px-4 py-2 pr-10 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-purple-500 w-full dark:text-white">
                                <div class="right-0 absolute inset-y-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Category Filter --}}
                        <div>
                            <label for="kategori" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Kategori
                            </label>
                            <select id="kategori" name="kategori"
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-purple-500 w-full dark:text-white">
                                <option value="">Semua Kategori</option>
                                <option value="peraturan_desa"
                                    {{ request('kategori') == 'peraturan_desa' ? 'selected' : '' }}>
                                    Peraturan Desa</option>
                                <option value="laporan_keuangan"
                                    {{ request('kategori') == 'laporan_keuangan' ? 'selected' : '' }}>
                                    Laporan Keuangan</option>
                                <option value="rencana_kerja"
                                    {{ request('kategori') == 'rencana_kerja' ? 'selected' : '' }}>
                                    Rencana Kerja</option>
                                <option value="dokumen_umum" {{ request('kategori') == 'dokumen_umum' ? 'selected' : '' }}>
                                    Dokumen Umum</option>
                            </select>
                        </div>

                        {{-- Year Filter --}}
                        <div>
                            <label for="tahun" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Tahun
                            </label>
                            <select id="tahun" name="tahun"
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-purple-500 w-full dark:text-white">
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
                            class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
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
                @if (request()->hasAny(['search', 'kategori', 'tahun']))
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            Menampilkan {{ $publikasi->total() }} hasil
                            @if (request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('kategori'))
                                dalam kategori
                                "<strong>{{ str_replace('_', ' ', ucwords(request('kategori'), '_')) }}</strong>"
                            @endif
                            @if (request('tahun'))
                                untuk tahun "<strong>{{ request('tahun') }}</strong>"
                            @endif
                        </p>
                    </div>
                @endif

                @if ($publikasi->count() > 0)
                    <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($publikasi as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-all duration-300 cursor-pointer group"
                                onclick="window.location.href='{{ route('desa.publikasi.preview', ['uri' => $desa->uri, 'id' => $item->id]) }}'">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <span
                                            class="inline-flex items-center bg-purple-100 dark:bg-purple-900 px-3 py-1 rounded-full font-medium text-purple-800 dark:text-purple-200 text-sm">
                                            {{ str_replace('_', ' ', ucwords($item->kategori, '_')) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ $item->tahun }}
                                        </span>
                                    </div>

                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                        {{ $item->judul }}
                                    </h3>

                                    @if ($item->deskripsi)
                                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                                            {{ Str::limit($item->deskripsi, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ $item->download_count }} unduhan
                                        </div>

                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a4 4 0 118 0v4m-4 8v2m-2 4h4m-4 0h8a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                                            </svg>
                                            {{ $item->published_at->format('d M Y') }}
                                        </div>
                                    </div>

                                    @if ($item->media->count() > 0)
                                        <div class="border-t pt-4 mt-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->media->count() }} Dokumen</span>
                                                <div class="flex items-center space-x-2" onclick="event.stopPropagation()">
                                                    @foreach($item->media->take(1) as $media)
                                                        <a href="{{ $media->getUrl() }}" target="_blank"
                                                           onclick="incrementDownload({{ $item->id }})"
                                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-purple-600 bg-purple-100 hover:bg-purple-200 dark:bg-purple-900 dark:text-purple-200 dark:hover:bg-purple-800 transition-colors">
                                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $publikasi->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Publikasi
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Publikasi dan dokumen resmi akan segera tersedia
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function incrementDownload(publikasiId) {
            fetch(`/api/publikasi/${publikasiId}/download`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        function applyFilters() {
            const search = document.getElementById('search').value;
            const kategori = document.getElementById('kategori').value;
            const tahun = document.getElementById('tahun').value;

            const params = new URLSearchParams(window.location.search);

            if (search) params.set('search', search);
            else params.delete('search');

            if (kategori) params.set('kategori', kategori);
            else params.delete('kategori');

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
        document.getElementById('kategori').addEventListener('change', applyFilters);
        document.getElementById('tahun').addEventListener('change', applyFilters);
    </script>
@endsection
