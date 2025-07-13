@props(['item'])

<div
    class="group relative flex flex-col bg-card border border-border shadow-sm hover:shadow-lg rounded-lg h-full overflow-hidden transition-shadow duration-300">
    <div class="aspect-video overflow-hidden">
        @if ($item->jenis === 'video')
            <div class="absolute inset-0 z-10 flex items-center justify-center bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button type="button" class="play-video-btn scale-150 text-white"
                    data-src="{{ $item->video_url }}">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if ($item->getFirstMediaUrl('thumbnail'))
            <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="flex justify-center items-center bg-muted w-full h-full">
                @if ($item->jenis === 'video')
                    <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                @else
                    <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor"
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
        <h3 class="mb-2 font-semibold text-card-foreground text-lg">{{ $item->judul }}</h3>

        <p class="flex-1 mb-4 text-muted-foreground text-sm">
            {{ Str::limit($item->deskripsi, 100) }}
        </p>

        <div class="flex justify-between items-center mt-auto text-muted-foreground text-xs">
            <span>{{ $item->created_at->format('d M Y') }}</span>
            <span
                class="bg-secondary text-secondary-foreground px-2 py-1 rounded-full">{{ ucfirst($item->jenis) }}</span>
        </div>
    </div>
</div>