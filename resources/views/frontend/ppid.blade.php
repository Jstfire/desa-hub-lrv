@extends('frontend.layouts.app')

@section('title', 'PPID - ' . $desa->nama_lengkap)

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
                        Pejabat Pengelola Informasi dan Dokumentasi {{ $desa->nama_lengkap }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Search Section --}}
        <section class="bg-gray-50 dark:bg-gray-800 py-8">
            <div class="mx-auto px-4 container">
                <div class="bg-white dark:bg-gray-900 shadow-lg p-6 rounded-lg">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                        {{-- Search --}}
                        <div class="md:col-span-2">
                            <label for="search" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Cari Informasi PPID
                            </label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berdasarkan judul atau konten..."
                                    class="dark:bg-gray-700 px-4 py-2 pr-10 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-gray-500 w-full dark:text-white">
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
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-gray-500 w-full dark:text-white">
                                <option value="">Semua Kategori</option>
                                <option value="informasi_wajib"
                                    {{ request('kategori') == 'informasi_wajib' ? 'selected' : '' }}>
                                    Informasi Wajib</option>
                                <option value="informasi_tersedia"
                                    {{ request('kategori') == 'informasi_tersedia' ? 'selected' : '' }}>
                                    Informasi Tersedia</option>
                                <option value="prosedur_layanan"
                                    {{ request('kategori') == 'prosedur_layanan' ? 'selected' : '' }}>
                                    Prosedur Layanan</option>
                                <option value="regulasi" {{ request('kategori') == 'regulasi' ? 'selected' : '' }}>
                                    Regulasi</option>
                            </select>
                        </div>
                    </div>

                    {{-- Filter Buttons --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button onclick="applyFilters()"
                            class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
                            <svg class="inline-block mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            Terapkan Filter
                        </button>
                        <button onclick="resetFilters()"
                            class="bg-gray-500 hover:bg-gray-600 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
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
                @if (request()->hasAny(['search', 'kategori']))
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            Menampilkan {{ $ppid->count() }} hasil
                            @if (request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('kategori'))
                                dalam kategori
                                "<strong>{{ str_replace('_', ' ', ucwords(request('kategori'), '_')) }}</strong>"
                            @endif
                        </p>
                    </div>
                @endif

                @if ($ppid->count() > 0)
                    <div class="mx-auto max-w-4xl">
                        @foreach ($ppid as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl mb-8 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer group"
                                onclick="window.location.href='{{ route('desa.ppid.preview', ['uri' => $desa->uri, 'id' => $item->id]) }}'">
                                <div class="p-8">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="font-bold text-gray-900 dark:text-white text-2xl md:text-3xl group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $item->judul }}
                                        </h2>
                                        <div class="flex items-center space-x-3">
                                            <span
                                                class="inline-flex items-center bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full font-medium text-gray-800 dark:text-gray-200 text-sm">
                                                {{ str_replace('_', ' ', ucwords($item->kategori, '_')) }}
                                            </span>
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
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
                                                        onclick="incrementDownload({{ $item->id }})"
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

    <script>
        function incrementDownload(ppidId) {
            fetch(`/api/ppid/${ppidId}/download`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Download tracked successfully');
                }
            })
            .catch(error => {
                console.error('Error tracking download:', error);
            });
        }

        function applyFilters() {
            const search = document.getElementById('search').value;
            const kategori = document.getElementById('kategori').value;

            const params = new URLSearchParams(window.location.search);

            if (search) params.set('search', search);
            else params.delete('search');

            if (kategori) params.set('kategori', kategori);
            else params.delete('kategori');

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
    </script>
@endsection
