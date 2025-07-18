@extends('frontend.desa.layouts.main')

@section('title', 'Berita - ' . $desa->nama_lengkap)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">
                Berita {{ $desa->nama_lengkap }}
            </h1>
            <p class="text-muted-foreground">
                Berita dan informasi terkini dari {{ $desa->nama_lengkap }}
            </p>
        </div>

        <!-- Filter Section -->
        <x-frontend.desa.components.filter-section :desa="$desa" :kategori="$kategori" :q="$q"
            :kategoriBerita="$kategoriBerita" />

        <!-- Layout Toggle -->
        <x-frontend.desa.components.layout-toggle />

        <!-- Grid View (Default) -->
        <div id="grid-container" class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($berita as $item)
                <x-frontend.desa.components.berita-card :item="$item" :desa="$desa" view="grid" />
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
                <x-frontend.desa.components.berita-card :item="$item" :desa="$desa" view="list" />
            @empty
                <div class="py-12 text-center">
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

        <!-- Pagination -->
        @if ($berita->hasPages())
            <div class="mt-8">
                <div class="flex justify-between items-center">
                    <div class="text-muted-foreground text-sm">
                        Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }} dari {{ $berita->total() }}
                        berita
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
