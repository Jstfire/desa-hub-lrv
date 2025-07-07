@extends('frontend.layouts.app')

@section('title', 'Berita')
@section('description', 'Berita terkini dari ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <!-- Header -->
    <section class="bg-primary py-16 text-white">
        <div class="mx-auto px-4 container">
            <div class="text-center">
                <h1 class="mb-4 font-bold text-4xl">Berita Terkini</h1>
                <p class="text-xl">Informasi dan berita terbaru dari {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }}
                    {{ $desa->nama }}</p>
            </div>
        </div>
    </section>

    <!-- Search & Filter -->
    <section class="bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto px-4 container">
            <div class="flex md:flex-row flex-col justify-between items-center gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <input type="text" id="searchBerita" placeholder="Cari berita..."
                            class="dark:bg-gray-800 py-2 pr-4 pl-10 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white">
                        <i class="top-3 left-3 absolute text-gray-400 fas fa-search"></i>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button
                        class="bg-primary hover:bg-opacity-90 px-4 py-2 rounded-lg text-white transition-colors layout-toggle active"
                        data-layout="grid">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button
                        class="bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 transition-colors layout-toggle"
                        data-layout="list">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita List -->
    <section class="bg-gray-50 dark:bg-gray-800 py-8">
        <div class="mx-auto px-4 container">
            <!-- Loading skeleton -->
            <div id="beritaSkeleton" class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @for ($i = 0; $i < 6; $i++)
                    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-lg overflow-hidden">
                        <x-skeleton class="w-full h-48" />
                        <div class="p-6">
                            <x-skeleton class="mb-4 w-3/4 h-6" />
                            <x-skeleton class="mb-2 w-full h-4" />
                            <x-skeleton class="mb-2 w-2/3 h-4" />
                            <div class="flex justify-between items-center mt-4">
                                <x-skeleton class="w-1/3 h-4" />
                                <x-skeleton class="w-1/4 h-4" />
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Actual content -->
            <div id="beritaContainer"
                class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 opacity-0 transition-opacity duration-300">
                @if ($berita->count() > 0)
                    @foreach ($berita as $item)
                        <article
                            class="bg-white dark:bg-gray-900 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow berita-item">
                            <div class="berita-image">
                                @if ($item->gambar_utama)
                                    <img src="{{ asset('storage/' . $item->gambar_utama) }}" alt="{{ $item->judul }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-48">
                                        <i class="text-gray-400 text-4xl fas fa-image"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center mb-3 text-gray-500 dark:text-gray-400 text-sm berita-meta">
                                    <i class="mr-2 fas fa-calendar"></i>
                                    <span>{{ $item->tanggal_publikasi->format('d M Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="mr-2 fas fa-user"></i>
                                    <span>{{ $item->user->name ?? 'Admin' }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="mr-2 fas fa-eye"></i>
                                    <span>{{ $item->views ?? 0 }}</span>
                                </div>

                                <h3 class="mb-3 font-bold text-gray-800 dark:text-white text-xl berita-title">
                                    <a href="{{ route('desa.berita.show', [$desa->uri, $item->slug]) }}"
                                        class="hover:text-primary transition-colors">
                                        {{ $item->judul }}
                                    </a>
                                </h3>

                                @if ($item->excerpt)
                                    <p class="mb-4 text-gray-600 dark:text-gray-300 berita-excerpt">
                                        {{ Str::limit($item->excerpt, 120) }}
                                    </p>
                                @endif

                                @if ($item->is_featured)
                                    <div class="mb-4">
                                        <span
                                            class="inline-flex items-center bg-yellow-100 px-2 py-1 rounded-full text-yellow-800 text-xs">
                                            <i class="mr-1 fas fa-star"></i>
                                            Berita Utama
                                        </span>
                                    </div>
                                @endif

                                <a href="{{ route('desa.berita.show', [$desa->uri, $item->slug]) }}"
                                    class="font-semibold text-primary hover:underline">
                                    Baca Selengkapnya <i class="fa-arrow-right ml-1 fas"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $berita->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div id="beritaContainer" class="opacity-0 py-16 text-center transition-opacity duration-300">
                <div
                    class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 mx-auto mb-6 rounded-full w-24 h-24">
                    <i class="text-gray-400 text-4xl fas fa-newspaper"></i>
                </div>
                <h3 class="mb-2 font-semibold text-gray-600 dark:text-gray-400 text-2xl">Belum Ada Berita</h3>
                <p class="text-gray-500 dark:text-gray-500">Tidak ada berita yang tersedia saat ini.</p>
            </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .berita-container-list {
            display: block !important;
        }

        .berita-container-list .berita-item {
            display: flex;
            flex-direction: row;
            margin-bottom: 1.5rem;
        }

        .berita-container-list .berita-image {
            flex-shrink: 0;
            width: 200px;
        }

        .berita-container-list .berita-image img,
        .berita-container-list .berita-image>div {
            height: 150px;
        }

        .berita-container-list .berita-content {
            flex: 1;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .berita-container-list .berita-item {
                flex-direction: column;
            }

            .berita-container-list .berita-image {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchBerita');
            const layoutToggles = document.querySelectorAll('.layout-toggle');
            const beritaContainer = document.getElementById('beritaContainer');
            const beritaItems = document.querySelectorAll('.berita-item');

            // Search functionality
            searchInput?.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                beritaItems.forEach(item => {
                    const title = item.querySelector('.berita-title').textContent.toLowerCase();
                    const excerpt = item.querySelector('.berita-excerpt')?.textContent
                        .toLowerCase() || '';

                    if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Layout toggle functionality
            layoutToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const layout = this.dataset.layout;

                    // Update active state
                    layoutToggles.forEach(t => {
                        t.classList.remove('bg-primary', 'text-white');
                        t.classList.add('bg-gray-300', 'dark:bg-gray-600', 'text-gray-700',
                            'dark:text-gray-300');
                    });

                    this.classList.remove('bg-gray-300', 'dark:bg-gray-600', 'text-gray-700',
                        'dark:text-gray-300');
                    this.classList.add('bg-primary', 'text-white');

                    // Update layout
                    if (layout === 'list') {
                        beritaContainer.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2',
                            'lg:grid-cols-3');
                        beritaContainer.classList.add('berita-container-list');

                        beritaItems.forEach(item => {
                            const content = item.querySelector('.p-6');
                            if (content) {
                                content.classList.add('berita-content');
                            }
                        });
                    } else {
                        beritaContainer.classList.remove('berita-container-list');
                        beritaContainer.classList.add('grid', 'grid-cols-1', 'md:grid-cols-2',
                            'lg:grid-cols-3');

                        beritaItems.forEach(item => {
                            const content = item.querySelector('.berita-content');
                            if (content) {
                                content.classList.remove('berita-content');
                            }
                        });
                    }
                });
            });

            // Handle skeleton loading
            const skeleton = document.getElementById('beritaSkeleton');
            const beritaContainer = document.getElementById('beritaContainer');

            // Show real content after simulated loading
            setTimeout(() => {
                skeleton.style.display = 'none';
                beritaContainer.classList.remove('opacity-0');
                beritaContainer.classList.add('opacity-100');
            }, 1500);

            // Preload images
            const images = document.querySelectorAll('.berita-item img');
            let loadedImages = 0;

            images.forEach(img => {
                if (img.complete) {
                    loadedImages++;
                    if (loadedImages === images.length) {
                        skeleton.style.display = 'none';
                        beritaContainer.classList.remove('opacity-0');
                        beritaContainer.classList.add('opacity-100');
                    }
                } else {
                    img.addEventListener('load', function() {
                        loadedImages++;
                        if (loadedImages === images.length) {
                            skeleton.style.display = 'none';
                            beritaContainer.classList.remove('opacity-0');
                            beritaContainer.classList.add('opacity-100');
                        }
                    });
                }
            });
        });
    </script>
@endpush
