@extends('frontend.desa.layouts.main')

@section('title', 'Galeri ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h2 class="mb-2 font-bold text-foreground text-3xl">Galeri</h2>
            <p class="text-muted-foreground">Kumpulan foto dan video kegiatan
                {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}</p>
        </div>

        <!-- Filter Jenis -->
        <div class="mb-6">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('desa.galeri', $desa->uri) }}"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 px-4 py-2 {{ !$jenis ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'bg-secondary text-secondary-foreground hover:bg-secondary/80' }}">
                    Semua
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'foto']) }}"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 px-4 py-2 {{ $jenis == 'foto' ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'bg-secondary text-secondary-foreground hover:bg-secondary/80' }}">
                    Foto
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'video']) }}"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 px-4 py-2 {{ $jenis == 'video' ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'bg-secondary text-secondary-foreground hover:bg-secondary/80' }}">
                    Video
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'infografis']) }}"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 px-4 py-2 {{ $jenis == 'infografis' ? 'bg-primary text-primary-foreground hover:bg-primary/90' : 'bg-secondary text-secondary-foreground hover:bg-secondary/80' }}">
                    Infografis
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        @if ($galeri->count() > 0)
            <div class="masonry-grid" data-masonry='{ "itemSelector": ".masonry-item", "columnWidth": ".masonry-sizer", "percentPosition": true, "gutter": 20 }'>
                <div class="masonry-sizer"></div>
                @foreach ($galeri as $item)
                    <div class="masonry-item group relative mb-5 w-full cursor-pointer break-inside-avoid overflow-hidden rounded-lg shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <div
                            onclick="openGalleryModal('{{ $item->getFirstMediaUrl('galeri') ?: 'https://via.placeholder.com/800x600' }}', '{{ $item->judul }}', '{{ $item->deskripsi }}', '{{ $item->jenis }}', '{{ $item->kategori }}', '{{ $item->created_at->translatedFormat('d F Y') }}', '{{ $item->user->name }}', '{{ $item->views }}', '{{ $item->source_url }}')">
                            <div class="absolute inset-0 z-10 flex flex-col items-center justify-center bg-black/50 p-4 text-center text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <h3 class="text-lg font-bold">{{ $item->judul }}</h3>
                                <p class="mt-2 text-sm">{{ Str::limit($item->deskripsi, 80) }}</p>
                            </div>
                            @if ($item->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                    class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <img src="https://via.placeholder.com/400x300.png?text=Gambar+Tidak+Tersedia"
                                    alt="Placeholder"
                                    class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $galeri->links() }}
            </div>
        @else
            <div class="py-16 text-center">
                <svg class="mx-auto w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <h3 class="mt-2 font-medium text-foreground text-sm">Tidak ada galeri</h3>
                <p class="mt-1 text-muted-foreground text-sm">
                    @if ($jenis)
                        Belum ada konten {{ $jenis }} yang tersedia.
                    @else
                        Belum ada galeri yang tersedia.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Gallery Modal -->
    <div id="galleryModal" tabindex="-1" aria-hidden="true"
        class="fixed inset-x-0 top-0 z-[60] h-full w-full flex-col items-center justify-center bg-black/80 p-4 backdrop-blur-sm md:flex hidden">
        <div class="relative mx-auto flex h-full w-full max-w-7xl flex-col items-center justify-center gap-4 md:flex-row">
            <!-- Close Button -->
            <button type="button" onclick="closeGalleryModal()"
                class="absolute -top-4 right-0 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-gray-300/20 text-white backdrop-blur-sm transition-all duration-300 ease-in-out hover:bg-gray-300/50">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <!-- Image Display -->
            <div class="relative flex h-full w-full items-center justify-center md:w-3/4">
                <div id="imageSpinner" class="absolute h-12 w-12 animate-spin rounded-full border-4 border-solid border-white border-t-transparent"></div>
                <img id="modalImage" src="" alt="" class="hidden h-auto max-h-full w-auto rounded-lg object-contain">
            </div>

            <!-- Information Panel -->
            <div
                class="relative flex h-auto max-h-full w-full flex-col overflow-y-auto rounded-lg bg-background/80 p-6 text-white backdrop-blur-md md:h-auto md:w-1/4">
                <div id="mediaInfoOnHover" class="absolute inset-0 z-10 flex cursor-pointer flex-col items-center justify-center bg-black/60 p-4 text-center opacity-0 transition-opacity duration-300">
                    <h3 class="text-lg font-bold">Informasi Media</h3>
                    <p class="mt-2 text-sm">Arahkan mouse untuk melihat detail</p>
                </div>
                <div id="mediaInfoDetails">
                    <h3 id="modalTitle" class="mb-3 text-2xl font-bold"></h3>
                    <p id="modalDescription" class="mb-4 text-sm"></p>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.47 2.118v-.082a2.25 2.25 0 012.25-2.25h15.318a2.25 2.25 0 012.25 2.25v.082a2.25 2.25 0 01-2.47-2.118 3 3 0 00-5.78-1.128a2.25 2.25 0 00-2.322-.165 2.25 2.25 0 00-2.322.165z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 6.375a4.5 4.5 0 017.5-3.062m0 0a4.5 4.5 0 017.5 3.062M12.75 6.375a3.375 3.375 0 01-3.375-3.375V3m3.375 3.375a3.375 3.375 0 00-3.375-3.375V3" />
                            </svg>
                            <span id="modalTypeCategory"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                            <span id="modalDate"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span id="modalAuthor"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639l4.43-4.43a1.012 1.012 0 011.431 0l4.43 4.43a1.012 1.012 0 010 .639l-4.43 4.43a1.012 1.012 0 01-1.431 0l-4.43-4.43z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 12.75h.008v.008h-.008v-.008z" />
                            </svg>
                            <span id="modalViews"></span>
                        </div>
                        <div id="source-container" class="flex items-center gap-3">
                            <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            </svg>
                            <a id="modalSourceLink" href="#" target="_blank" rel="noopener noreferrer" class="hover:underline">Lihat Sumber</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .masonry-grid {
            column-count: 1;
            column-gap: 1.25rem;
        }

        @media (min-width: 640px) {
            .masonry-grid {
                column-count: 2;
            }
        }

        @media (min-width: 768px) {
            .masonry-grid {
                column-count: 3;
            }
        }

        @media (min-width: 1024px) {
            .masonry-grid {
                column-count: 4;
            }
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 1.25rem;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/gallery.js')
@endpush
