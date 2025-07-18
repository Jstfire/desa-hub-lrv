@extends('frontend.desa.layouts.main')

@section('title', 'PPID - ' . $desa->nama_lengkap)

@section('content')
    <div class="bg-background py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-foreground text-2xl">Pejabat Pengelola Informasi dan Dokumentasi
                        (PPID)</h1>
                    <p class="text-muted-foreground">{{ $desa->nama_lengkap }}</p>
                </div>

                <div class="flex space-x-2">
                    <button id="grid-view" class="bg-primary hover:bg-primary/90 p-2 rounded text-primary-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button id="list-view" class="bg-muted hover:bg-muted/80 p-2 rounded text-muted-foreground">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="bg-card shadow-sm mb-6 p-6 border border-border rounded-lg">
                <form action="{{ route('desa.ppid', $desa->uri) }}" method="GET" class="flex md:flex-row flex-col gap-4">
                    <div class="flex-1">
                        <label for="search" class="block mb-1 font-medium text-foreground text-sm">Cari
                            Dokumen</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul atau deskripsi"
                            class="bg-background px-3 py-2 border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 w-full text-foreground placeholder:text-muted-foreground">
                    </div>

                    <div class="w-full md:w-1/4">
                        <label for="kategori" class="block mb-1 font-medium text-foreground text-sm">Kategori</label>
                        <select id="kategori" name="kategori"
                            class="bg-background px-3 py-2 border border-input rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 w-full text-foreground">
                            <option value="">Semua Kategori</option>
                            <option value="informasi_berkala"
                                {{ request('kategori') == 'informasi_berkala' ? 'selected' : '' }}>Informasi Berkala
                            </option>
                            <option value="informasi_serta_merta"
                                {{ request('kategori') == 'informasi_serta_merta' ? 'selected' : '' }}>Informasi Serta Merta
                            </option>
                            <option value="informasi_setiap_saat"
                                {{ request('kategori') == 'informasi_setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat
                            </option>
                            <option value="informasi_dikecualikan"
                                {{ request('kategori') == 'informasi_dikecualikan' ? 'selected' : '' }}>Informasi
                                Dikecualikan</option>
                            <option value="lainnya" {{ request('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                    </div>

                    <div class="self-end w-full md:w-1/6">
                        <button type="submit"
                            class="bg-primary hover:bg-primary/90 px-4 py-2 rounded w-full font-semibold text-primary-foreground">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Grid View (default) -->
            <div id="grid-container" class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @forelse($ppid as $dokumen)
                    <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                @php
                                    $badgeClasses = [
                                        'informasi_berkala' => 'bg-blue-100 text-blue-800',
                                        'informasi_serta_merta' => 'bg-green-100 text-green-800',
                                        'informasi_setiap_saat' => 'bg-yellow-100 text-yellow-800',
                                        'informasi_dikecualikan' => 'bg-red-100 text-red-800',
                                    ];
                                    $badgeClass = $badgeClasses[$dokumen->kategori] ?? 'bg-muted text-muted-foreground';
                                @endphp
                                <span class="px-3 py-1 rounded-full font-semibold text-xs {{ $badgeClass }}">
                                    {{ str_replace('_', ' ', ucwords($dokumen->kategori, '_')) }}
                                </span>
                                <span
                                    class="text-muted-foreground text-sm">{{ $dokumen->published_at->format('d M Y') }}</span>
                            </div>

                            <h2 class="mb-2 font-semibold text-card-foreground text-xl">{{ $dokumen->judul }}</h2>

                            <p class="mb-4 text-muted-foreground line-clamp-3">{{ $dokumen->deskripsi }}</p>

                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-border">
                                <span class="flex items-center text-muted-foreground text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    {{ $dokumen->download_count }} unduhan
                                </span>
                                <a href="{{ route('desa.ppid.download', ['uri' => $desa->uri, 'id' => $dokumen->id]) }}"
                                    class="inline-flex items-center bg-primary hover:bg-primary/90 px-3 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 font-medium text-primary-foreground text-sm leading-4">
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
                @empty
                    <div class="col-span-full bg-card shadow-sm p-6 border border-border rounded-lg">
                        <p class="text-muted-foreground">Belum ada dokumen PPID yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <!-- List View (hidden by default) -->
            <div id="list-container" class="hidden space-y-4">
                @forelse($ppid as $dokumen)
                    <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex md:flex-row flex-col md:justify-between md:items-center gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        @php
                                            $badgeClasses = [
                                                'informasi_berkala' => 'bg-blue-100 text-blue-800',
                                                'informasi_serta_merta' => 'bg-green-100 text-green-800',
                                                'informasi_setiap_saat' => 'bg-yellow-100 text-yellow-800',
                                                'informasi_dikecualikan' => 'bg-red-100 text-red-800',
                                            ];
                                            $badgeClass =
                                                $badgeClasses[$dokumen->kategori] ?? 'bg-muted text-muted-foreground';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full font-semibold text-xs {{ $badgeClass }}">
                                            {{ str_replace('_', ' ', ucwords($dokumen->kategori, '_')) }}
                                        </span>
                                        <span
                                            class="text-muted-foreground text-sm">{{ $dokumen->published_at->format('d M Y') }}</span>
                                    </div>

                                    <h2 class="mb-2 font-semibold text-card-foreground text-xl">
                                        {{ $dokumen->judul }}</h2>

                                    <p class="text-muted-foreground">{{ $dokumen->deskripsi }}</p>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="flex items-center text-muted-foreground text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        {{ $dokumen->download_count }} unduhan
                                    </span>
                                    <a href="{{ route('desa.ppid.download', ['uri' => $desa->uri, 'id' => $dokumen->id]) }}"
                                        class="inline-flex items-center bg-primary hover:bg-primary/90 px-4 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 font-medium text-primary-foreground text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-card shadow-sm p-6 border border-border rounded-lg">
                        <p class="text-muted-foreground">Belum ada dokumen PPID yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $ppid->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const gridView = document.getElementById('grid-view');
                const listView = document.getElementById('list-view');
                const gridContainer = document.getElementById('grid-container');
                const listContainer = document.getElementById('list-container');

                // Function to toggle view
                function setView(view) {
                    if (view === 'grid') {
                        gridContainer.classList.remove('hidden');
                        listContainer.classList.add('hidden');
                        gridView.classList.remove('bg-muted', 'hover:bg-muted/80', 'text-muted-foreground');
                        gridView.classList.add('bg-primary', 'hover:bg-primary/90', 'text-primary-foreground');
                        listView.classList.remove('bg-primary', 'hover:bg-primary/90', 'text-primary-foreground');
                        listView.classList.add('bg-muted', 'hover:bg-muted/80', 'text-muted-foreground');

                        localStorage.setItem('ppidViewPreference', 'grid');
                    } else {
                        gridContainer.classList.add('hidden');
                        listContainer.classList.remove('hidden');
                        listView.classList.remove('bg-muted', 'hover:bg-muted/80', 'text-muted-foreground');
                        listView.classList.add('bg-primary', 'hover:bg-primary/90', 'text-primary-foreground');
                        gridView.classList.remove('bg-primary', 'hover:bg-primary/90', 'text-primary-foreground');
                        gridView.classList.add('bg-muted', 'hover:bg-muted/80', 'text-muted-foreground');

                        localStorage.setItem('ppidViewPreference', 'list');
                    }
                }

                // Load saved preference or default to grid
                const savedView = localStorage.getItem('ppidViewPreference') || 'grid';
                setView(savedView);

                // Add event listeners
                gridView.addEventListener('click', () => setView('grid'));
                listView.addEventListener('click', () => setView('list'));
            });
        </script>
    @endpush
@endsection
