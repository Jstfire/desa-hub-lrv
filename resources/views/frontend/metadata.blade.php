@extends('frontend.layouts.app')

@section('title', 'Metadata - ' . $desa->nama_lengkap)

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
                        Informasi detail tentang {{ $desa->nama_lengkap }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Search and Filter Section --}}
        <section class="bg-gray-50 dark:bg-gray-800 py-8">
            <div class="mx-auto px-4 container">
                <div class="bg-white dark:bg-gray-900 shadow-lg p-6 rounded-lg">
                    <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                        {{-- Search --}}
                        <div class="md:col-span-2">
                            <label for="search" class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">
                                Cari Informasi Metadata
                            </label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berdasarkan judul atau konten..."
                                    class="dark:bg-gray-700 px-4 py-2 pr-10 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-teal-500 w-full dark:text-white">
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
                                Jenis
                            </label>
                            <select id="jenis" name="jenis"
                                class="dark:bg-gray-700 px-4 py-2 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-teal-500 w-full dark:text-white">
                                <option value="">Semua Jenis</option>
                                <option value="demografi" {{ request('jenis') == 'demografi' ? 'selected' : '' }}>
                                    Demografi</option>
                                <option value="geografis" {{ request('jenis') == 'geografis' ? 'selected' : '' }}>
                                    Geografis</option>
                                <option value="ekonomi" {{ request('jenis') == 'ekonomi' ? 'selected' : '' }}>
                                    Ekonomi</option>
                                <option value="sosial" {{ request('jenis') == 'sosial' ? 'selected' : '' }}>
                                    Sosial</option>
                                <option value="infrastruktur" {{ request('jenis') == 'infrastruktur' ? 'selected' : '' }}>
                                    Infrastruktur</option>
                            </select>
                        </div>
                    </div>

                    {{-- Filter Buttons --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button onclick="applyFilters()"
                            class="bg-teal-600 hover:bg-teal-700 px-4 py-2 rounded-lg font-medium text-white transition-colors duration-200">
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
                @if (request()->hasAny(['search', 'jenis']))
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">
                            Menampilkan {{ $metadata->count() }} hasil
                            @if (request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if (request('jenis'))
                                dengan jenis "<strong>{{ str_replace('_', ' ', ucfirst(request('jenis'))) }}</strong>"
                            @endif
                        </p>
                    </div>
                @endif

                @if ($metadata->count() > 0)
                    <div class="mx-auto max-w-4xl">
                        @foreach ($metadata as $item)
                            <div class="group bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl mb-8 rounded-lg overflow-hidden transition-all duration-300 cursor-pointer"
                                onclick="window.location.href='{{ route('desa.metadata.preview', ['uri' => $desa->uri, 'id' => $item->id]) }}'">
                                @if ($item->getFirstMediaUrl('gambar'))
                                    <img src="{{ $item->getFirstMediaUrl('gambar') }}" alt="{{ $item->judul }}"
                                        class="w-full h-64 object-cover">
                                @endif

                                <div class="p-8">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2
                                            class="font-bold text-gray-900 dark:text-white group-hover:text-teal-600 text-2xl md:text-3xl transition-colors">
                                            {{ $item->judul }}
                                        </h2>
                                        <div class="flex items-center space-x-3">
                                            <span
                                                class="inline-flex items-center bg-teal-100 dark:bg-teal-900 px-3 py-1 rounded-full font-medium text-teal-800 dark:text-teal-200 text-sm">
                                                {{ str_replace('_', ' ', ucwords($item->jenis, '_')) }}
                                            </span>
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-600 transition-colors"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        @if($item->tahun)
                                            <span class="inline-flex items-center bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded font-medium text-gray-700 dark:text-gray-300 text-sm">
                                                <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $item->tahun }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="dark:prose-invert max-w-none prose prose-lg">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            {{ Str::limit(strip_tags($item->konten), 200) }}</p>
                                    </div>

                                    @if ($item->media->where('collection_name', 'dokumen')->count() > 0)
                                        <div class="mt-6 pt-6 border-gray-200 dark:border-gray-700 border-t">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-gray-900 dark:text-white text-sm">
                                                    {{ $item->media->where('collection_name', 'dokumen')->count() }}
                                                    Dokumen Terkait
                                                </span>
                                                <div class="flex items-center space-x-2" onclick="event.stopPropagation()">
                                                    @foreach ($item->media->where('collection_name', 'dokumen')->take(1) as $dokumen)
                                                        <a href="{{ $dokumen->getUrl() }}" target="_blank"
                                                            onclick="incrementDownload({{ $item->id }})"
                                                            class="inline-flex items-center bg-blue-100 hover:bg-blue-200 px-3 py-1.5 border border-transparent rounded font-medium text-blue-600 text-xs transition-colors">
                                                            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
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

    <script>
        function incrementDownload(metadataId) {
            fetch(`/api/metadata/${metadataId}/download`, {
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
            const jenis = document.getElementById('jenis').value;

            const params = new URLSearchParams(window.location.search);

            if (search) params.set('search', search);
            else params.delete('search');

            if (jenis) params.set('jenis', jenis);
            else params.delete('jenis');

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
    </script>
@endsection
