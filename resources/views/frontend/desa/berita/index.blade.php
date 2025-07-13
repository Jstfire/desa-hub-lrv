@extends('frontend.desa.layouts.main')

@section('title', 'Berita - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">
                Berita {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="text-muted-foreground">
                Berita dan informasi terkini dari {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </p>
        </div>

        <!-- Filter Section -->
        <div class="bg-card border border-border shadow-sm mb-8 p-4 rounded-lg">
            <form action="{{ route('desa.berita', $desa->uri) }}" method="GET" class="flex flex-wrap gap-4">
                <div class="w-full md:w-auto">
                    <label for="search"
                        class="block mb-1 font-medium text-card-foreground text-sm">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari berita..."
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                </div>

                <div class="w-full md:w-auto">
                    <label for="kategori"
                        class="block mb-1 font-medium text-card-foreground text-sm">Kategori</label>
                    <select id="kategori" name="kategori"
                        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="">Semua Kategori</option>
                        <option value="berita" {{ request('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="pengumuman" {{ request('kategori') == 'pengumuman' ? 'selected' : '' }}>Pengumuman
                        </option>
                        <option value="kegiatan" {{ request('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="program" {{ request('kategori') == 'program' ? 'selected' : '' }}>Program</option>
                    </select>
                </div>

                <div class="flex items-end w-full md:w-auto">
                    <button type="submit"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Filter</button>
                    @if (request('search') || request('kategori'))
                        <a href="{{ route('desa.berita', $desa->uri) }}"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 ml-2">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Layout Toggle -->
        <div class="flex justify-end mb-6">
            <div class="bg-card border border-border shadow-sm rounded-lg overflow-hidden">
                <button id="grid-view" class="px-4 py-2 text-card-foreground hover:bg-accent hover:text-accent-foreground transition-colors" aria-label="Tampilan Grid">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </button>
                <button id="list-view" class="px-4 py-2 text-card-foreground hover:bg-accent hover:text-accent-foreground transition-colors" aria-label="Tampilan List">
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
            @forelse($berita as $item)
                <article class="bg-card border border-border shadow-sm hover:shadow-md transition-shadow rounded-lg overflow-hidden">
                    <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}" class="block">
                        @if ($item->getFirstMediaUrl('thumbnail'))
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="aspect-video bg-muted flex items-center justify-center">
                                <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif

                        <div class="p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="bg-primary/10 text-primary px-2 py-1 rounded-full text-xs font-medium">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                                <span class="text-muted-foreground text-sm">
                                    {{ $item->published_at->format('d M Y') }}
                                </span>
                            </div>

                            <h3 class="font-semibold text-card-foreground text-lg mb-2 line-clamp-2">
                                {{ $item->judul }}
                            </h3>

                            <p class="text-muted-foreground text-sm line-clamp-3 mb-4">
                                {{ Str::limit(strip_tags($item->konten), 120) }}
                            </p>

                            <div class="flex items-center justify-between">
                                <span class="text-primary text-sm font-medium">
                                    Baca Selengkapnya
                                </span>
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-muted-foreground"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h2 class="mb-2 font-semibold text-foreground text-xl">Belum Ada Berita</h2>
                    <p class="text-muted-foreground">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- List View (Hidden by default) -->
        <div id="list-container" class="hidden space-y-6">
            @forelse($berita as $item)
                <article class="bg-card border border-border shadow-sm hover:shadow-md transition-shadow rounded-lg overflow-hidden">
                    <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}" class="block">
                        <div class="flex flex-col md:flex-row">
                            @if ($item->getFirstMediaUrl('thumbnail'))
                                <div class="md:w-1/3 aspect-video md:aspect-square overflow-hidden">
                                    <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                </div>
                            @else
                                <div class="md:w-1/3 aspect-video md:aspect-square bg-muted flex items-center justify-center">
                                    <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-primary/10 text-primary px-2 py-1 rounded-full text-xs font-medium">
                                        {{ ucfirst($item->kategori) }}
                                    </span>
                                    <span class="text-muted-foreground text-sm">
                                        {{ $item->published_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h3 class="font-semibold text-card-foreground text-xl mb-3">
                                    {{ $item->judul }}
                                </h3>

                                <p class="text-muted-foreground mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($item->konten), 200) }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <span class="text-primary text-sm font-medium">
                                        Baca Selengkapnya
                                    </span>
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-4 w-12 h-12 text-muted-foreground" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h2 class="mb-2 font-semibold text-foreground text-xl">Belum Ada Berita</h2>
                    <p class="text-muted-foreground">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($berita->hasPages())
            <div class="mt-8">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-muted-foreground">
                        Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari {{ $berita->total() }} berita
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $berita->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gridView = document.getElementById('grid-view');
            const listView = document.getElementById('list-view');
            const gridContainer = document.getElementById('grid-container');
            const listContainer = document.getElementById('list-container');

            // Check local storage for preferred view
            const preferredView = localStorage.getItem('beritaView') || 'grid';

            // Set initial view based on preference
            if (preferredView === 'list') {
                gridContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');
                gridView.classList.remove('bg-accent', 'text-accent-foreground');
                listView.classList.add('bg-accent', 'text-accent-foreground');
            }

            // Add event listeners
            gridView.addEventListener('click', function() {
                gridContainer.classList.remove('hidden');
                listContainer.classList.add('hidden');
                gridView.classList.add('bg-accent', 'text-accent-foreground');
                listView.classList.remove('bg-accent', 'text-accent-foreground');
                localStorage.setItem('beritaView', 'grid');
            });

            listView.addEventListener('click', function() {
                gridContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');
                gridView.classList.remove('bg-accent', 'text-accent-foreground');
                listView.classList.add('bg-accent', 'text-accent-foreground');
                localStorage.setItem('beritaView', 'list');
            });
        });
    </script>
@endsection
