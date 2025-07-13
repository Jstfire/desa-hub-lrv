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
            <div class="gap-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($galeri as $item)
                    <x-frontend.desa.components.galeri-card :item="$item" />
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

    <!-- Video Modal -->
    <div id="videoModal" class="hidden z-50 fixed inset-0 justify-center items-center">
        <div class="absolute inset-0 bg-black/80"></div>
        <div class="z-10 bg-card border border-border mx-4 p-2 rounded-lg w-full max-w-4xl">
            <div class="flex justify-end mb-2">
                <button id="closeVideoModal"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10 text-muted-foreground">
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
