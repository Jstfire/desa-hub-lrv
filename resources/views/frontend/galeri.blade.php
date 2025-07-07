@extends('frontend.layouts.app')

@section('title', 'Galeri - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-pink-600 to-pink-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Galeri
                    </h1>
                    <p class="opacity-90 text-xl">
                        Dokumentasi kegiatan dan keindahan {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($galeri->count() > 0)
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($galeri as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow duration-300">
                                @if ($item->jenis === 'foto')
                                    @if ($item->getFirstMediaUrl('media'))
                                        <div class="group relative cursor-pointer"
                                            onclick="openModal('{{ $item->getFirstMediaUrl('media') }}', '{{ $item->judul }}')">
                                            <img src="{{ $item->getFirstMediaUrl('media') }}" alt="{{ $item->judul }}"
                                                class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                            <div
                                                class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-300">
                                                <svg class="opacity-0 group-hover:opacity-100 w-8 h-8 text-white transition-opacity duration-300"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div
                                            class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-64">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                @elseif($item->jenis === 'video')
                                    @if ($item->getFirstMediaUrl('media'))
                                        <div class="relative">
                                            <video controls class="w-full h-64 object-cover">
                                                <source src="{{ $item->getFirstMediaUrl('media') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @else
                                        <div
                                            class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-64">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                @endif

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span
                                            class="inline-flex items-center bg-pink-100 dark:bg-pink-900 px-2 py-1 rounded-full font-medium text-pink-800 dark:text-pink-200 text-xs">
                                            {{ ucfirst($item->jenis) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">
                                            {{ $item->published_at->format('d M Y') }}
                                        </span>
                                    </div>

                                    <h3 class="mb-1 font-semibold text-gray-900 dark:text-white text-lg">
                                        {{ $item->judul }}
                                    </h3>

                                    @if ($item->kategori)
                                        <p class="mb-2 text-gray-600 dark:text-gray-300 text-sm">
                                            {{ $item->kategori }}
                                        </p>
                                    @endif

                                    @if ($item->deskripsi)
                                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                                            {{ Str::limit($item->deskripsi, 80) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $galeri->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Galeri
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Galeri foto dan video akan segera tersedia
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Modal for image viewer --}}
    <div id="imageModal" class="hidden z-50 fixed inset-0 bg-black bg-opacity-75 p-4" style="display: none;">
        <div class="flex justify-center items-center min-h-full">
            <div class="relative max-w-4xl max-h-full">
                <button onclick="closeModal()" class="top-4 right-4 z-10 absolute text-white hover:text-gray-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
                <div class="right-4 bottom-4 left-4 absolute bg-black bg-opacity-50 p-4 rounded text-white">
                    <h3 id="modalTitle" class="font-semibold text-lg"></h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(imageUrl, title) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalTitle').textContent = title;
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
@endsection
