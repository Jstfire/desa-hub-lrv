@extends('frontend.desa.layouts.main')

@section('title', 'Berita - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-gray-900 dark:text-white text-3xl">
                Berita {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Berita dan informasi terkini dari {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-gray-800 shadow-sm mb-8 p-4 rounded-lg">
            <form action="{{ route('desa.berita', $desa->uri) }}" method="GET" class="flex flex-wrap gap-4">
                <div class="w-full md:w-auto">
                    <label for="search"
                        class="block mb-1 font-medium text-gray-700 dark:text-gray-300 text-sm">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari berita..."
                        class="block dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:ring focus:ring-primary-500 w-full dark:text-white">
                </div>

                <div class="w-full md:w-auto">
                    <label for="kategori"
                        class="block mb-1 font-medium text-gray-700 dark:text-gray-300 text-sm">Kategori</label>
                    <select id="kategori" name="kategori"
                        class="block dark:bg-gray-700 focus:ring-opacity-50 shadow-sm border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:ring focus:ring-primary-500 w-full dark:text-white">
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
                        class="bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md text-white">Filter</button>
                    @if (request('search') || request('kategori'))
                        <a href="{{ route('desa.berita', $desa->uri) }}"
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
            @forelse($berita as $item)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg overflow-hidden transition-shadow">
                    <div class="relative bg-gray-200 dark:bg-gray-700 h-48">
                        @if ($item->getFirstMediaUrl('thumbnail'))
                            <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover">
                        @endif

                        <div class="top-0 right-0 absolute mt-2 mr-2">
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                            {{ $item->kategori == 'berita' ? 'bg-blue-500' : '' }}
                            {{ $item->kategori == 'pengumuman' ? 'bg-yellow-500' : '' }}
                            {{ $item->kategori == 'kegiatan' ? 'bg-green-500' : '' }}
                            {{ $item->kategori == 'program' ? 'bg-purple-500' : '' }}
                            text-white">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                            <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                                class="hover:text-primary-600 dark:hover:text-primary-400">
                                {{ $item->judul }}
                            </a>
                        </h3>

                        <div class="flex items-center mb-4 text-gray-500 dark:text-gray-400 text-sm">
                            <span>{{ $item->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->view_count }} dilihat</span>
                        </div>

                        <p class="mb-4 text-gray-600 dark:text-gray-300 line-clamp-3">
                            {{ Str::limit(strip_tags($item->konten), 150) }}
                        </p>

                        <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                            class="inline-block text-primary-600 dark:text-primary-400 hover:underline">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-500"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h2 class="mb-2 font-semibold text-gray-700 dark:text-gray-300 text-xl">Belum Ada Berita</h2>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- List View (Hidden by default) -->
        <div id="list-container" class="hidden space-y-6">
            @forelse($berita as $item)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg overflow-hidden transition-shadow">
                    <div class="md:flex">
                        <div class="relative bg-gray-200 dark:bg-gray-700 md:w-1/3 h-48 md:h-auto">
                            @if ($item->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover">
                            @endif

                            <div class="top-0 right-0 absolute mt-2 mr-2">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                                {{ $item->kategori == 'berita' ? 'bg-blue-500' : '' }}
                                {{ $item->kategori == 'pengumuman' ? 'bg-yellow-500' : '' }}
                                {{ $item->kategori == 'kegiatan' ? 'bg-green-500' : '' }}
                                {{ $item->kategori == 'program' ? 'bg-purple-500' : '' }}
                                text-white">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 md:w-2/3">
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                                <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                                    class="hover:text-primary-600 dark:hover:text-primary-400">
                                    {{ $item->judul }}
                                </a>
                            </h3>

                            <div class="flex items-center mb-4 text-gray-500 dark:text-gray-400 text-sm">
                                <span>{{ $item->published_at->format('d M Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item->user->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item->view_count }} dilihat</span>
                            </div>

                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                {{ Str::limit(strip_tags($item->konten), 250) }}
                            </p>

                            <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                                class="inline-block text-primary-600 dark:text-primary-400 hover:underline">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h2 class="mb-2 font-semibold text-gray-700 dark:text-gray-300 text-xl">Belum Ada Berita</h2>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $berita->links() }}
        </div>
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
                gridView.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                listView.classList.add('bg-gray-200', 'dark:bg-gray-700');
            }

            // Add event listeners
            gridView.addEventListener('click', function() {
                gridContainer.classList.remove('hidden');
                listContainer.classList.add('hidden');
                gridView.classList.add('bg-gray-200', 'dark:bg-gray-700');
                listView.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                localStorage.setItem('beritaView', 'grid');
            });

            listView.addEventListener('click', function() {
                gridContainer.classList.add('hidden');
                listContainer.classList.remove('hidden');
                gridView.classList.remove('bg-gray-200', 'dark:bg-gray-700');
                listView.classList.add('bg-gray-200', 'dark:bg-gray-700');
                localStorage.setItem('beritaView', 'list');
            });
        });
    </script>
@endsection
