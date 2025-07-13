@props(['item', 'desa', 'view' => 'grid'])

@if ($view === 'grid')
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
@else
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
@endif