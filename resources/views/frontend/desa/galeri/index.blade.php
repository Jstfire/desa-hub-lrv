@extends('frontend.desa.layouts.main')

@section('title', 'Galeri ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h2 class="mb-2 font-bold text-gray-800 dark:text-white text-3xl">Galeri</h2>
            <p class="text-gray-600 dark:text-gray-300">Kumpulan foto dan video kegiatan
                {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}</p>
        </div>

        <!-- Filter Jenis -->
        <div class="mb-6">
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ route('desa.galeri', $desa->uri) }}"
                    class="px-4 py-2 rounded-full {{ !$jenis ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                    Semua
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'foto']) }}"
                    class="px-4 py-2 rounded-full {{ $jenis == 'foto' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                    Foto
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'video']) }}"
                    class="px-4 py-2 rounded-full {{ $jenis == 'video' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                    Video
                </a>
                <a href="{{ route('desa.galeri.jenis', [$desa->uri, 'infografis']) }}"
                    class="px-4 py-2 rounded-full {{ $jenis == 'infografis' ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200' }}">
                    Infografis
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        @if ($galeri->count() > 0)
            <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($galeri as $item)
                    <div
                        class="flex flex-col bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg h-full overflow-hidden transition-shadow duration-300">
                        <div class="relative aspect-video overflow-hidden">
                            @if ($item->jenis === 'video')
                                <div class="z-10 absolute inset-0 flex justify-center items-center">
                                    <button type="button" class="play-video-btn" data-src="{{ $item->video_url }}">
                                        <svg class="opacity-80 w-16 h-16 text-white" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            @if ($item->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-full">
                                    @if ($item->jenis === 'video')
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col flex-1 p-4">
                            <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-lg">{{ $item->judul }}</h3>

                            <p class="flex-1 mb-4 text-gray-600 dark:text-gray-400 text-sm">
                                {{ Str::limit($item->deskripsi, 100) }}
                            </p>

                            <div class="flex justify-between items-center mt-auto text-gray-500 dark:text-gray-400 text-xs">
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                                <span
                                    class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">{{ ucfirst($item->jenis) }}</span>
                            </div>
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
                <svg class="mx-auto w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <h3 class="mt-2 font-medium text-gray-900 dark:text-gray-200 text-sm">Tidak ada galeri</h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm">
                    @if ($jenis)
                        Belum ada konten {{ $jenis }} yang tersedia.
                    @else
                        Belum ada galeri yang tersedia.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Video Modal -->
    <div id="videoModal" class="hidden z-50 fixed inset-0 justify-center items-center">
        <div class="absolute inset-0 bg-black opacity-75"></div>
        <div class="z-10 bg-white dark:bg-gray-800 mx-4 p-2 rounded-lg w-full max-w-4xl">
            <div class="flex justify-end mb-2">
                <button id="closeVideoModal"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-white dark:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="aspect-h-9 aspect-w-16">
                <div id="videoContainer" class="w-full h-full"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Video modal functionality
        const videoModal = document.getElementById('videoModal');
        const videoContainer = document.getElementById('videoContainer');
        const closeVideoModal = document.getElementById('closeVideoModal');
        const playButtons = document.querySelectorAll('.play-video-btn');

        playButtons.forEach(button => {
            button.addEventListener('click', () => {
                const videoSrc = button.getAttribute('data-src');

                // Check if YouTube or other video source
                if (videoSrc.includes('youtube.com') || videoSrc.includes('youtu.be')) {
                    // Extract YouTube ID
                    let youtubeId = '';
                    if (videoSrc.includes('youtube.com/watch?v=')) {
                        youtubeId = videoSrc.split('v=')[1].split('&')[0];
                    } else if (videoSrc.includes('youtu.be/')) {
                        youtubeId = videoSrc.split('youtu.be/')[1];
                    }

                    if (youtubeId) {
                        videoContainer.innerHTML =
                            `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${youtubeId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                    }
                } else {
                    videoContainer.innerHTML =
                        `<video width="100%" height="100%" controls><source src="${videoSrc}" type="video/mp4">Your browser does not support the video tag.</video>`;
                }

                videoModal.classList.remove('hidden');
            });
        });

        closeVideoModal.addEventListener('click', () => {
            videoModal.classList.add('hidden');
            videoContainer.innerHTML = '';
        });

        // Close modal when clicking outside
        videoModal.addEventListener('click', (e) => {
            if (e.target === videoModal) {
                videoModal.classList.add('hidden');
                videoContainer.innerHTML = '';
            }
        });
    </script>
@endsection
