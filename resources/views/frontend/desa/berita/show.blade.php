@extends('frontend.desa.layouts.main')

@section('title', $berita->judul . ' - ' . $desa->nama_lengkap)

@section('head')
    <!-- Open Graph Meta Tags for Social Media -->
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($berita->konten), 200) }}">
    @if ($berita->getFirstMediaUrl('thumbnail'))
        <meta property="og:image" content="{{ $berita->getFirstMediaUrl('thumbnail') }}">
    @endif
    <meta property="og:url" content="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $berita->slug]) }}">
    <meta property="og:type" content="article">
@endsection

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <nav class="flex items-center mb-4 text-muted-foreground text-sm">
                <a href="{{ route('desa.index', $desa->uri) }}" class="hover:text-foreground transition-colors">Beranda</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('desa.berita', $desa->uri) }}" class="hover:text-foreground transition-colors">Berita</a>
                <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-foreground">{{ Str::limit($berita->judul, 30) }}</span>
            </nav>

            <h1 class="mb-4 font-bold text-foreground text-3xl">
                {{ $berita->judul }}
            </h1>

            <div class="flex flex-wrap items-center mb-6 text-muted-foreground text-sm">
                <div class="mr-4 mb-2">
                    <span class="bg-primary/10 px-2 py-1 rounded-full font-medium text-primary text-xs">
                        {{ ucfirst($berita->kategori) }}
                    </span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>{{ $berita->published_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center mr-4 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>{{ $berita->user->name }}</span>
                </div>
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ $berita->view_count }} kali dilihat</span>
                </div>
            </div>
        </div>

        <div class="gap-8 grid grid-cols-1 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <!-- Main Content -->
                <article class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                    @if ($berita->getFirstMediaUrl('thumbnail'))
                        <div class="relative w-full h-72">
                            <img src="{{ $berita->getFirstMediaUrl('thumbnail') }}" alt="{{ $berita->judul }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="max-w-none text-card-foreground prose prose-lg">
                            {!! $berita->konten !!}
                        </div>

                        @if ($berita->tags)
                            <div class="mt-6 pt-6 border-t border-border">
                                <div class="flex flex-wrap items-center">
                                    <span class="mr-2 text-muted-foreground">Tags:</span>
                                    @foreach (explode(',', $berita->tags) as $tag)
                                        <span
                                            class="bg-secondary mr-2 mb-2 px-3 py-1 rounded-full text-secondary-foreground text-sm">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Share Buttons -->
                        <div class="mt-6 pt-6 border-t border-border">
                            <div class="flex items-center">
                                <span class="mr-4 text-muted-foreground">Bagikan:</span>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $berita->slug])) }}"
                                    target="_blank"
                                    class="inline-flex justify-center items-center hover:bg-accent disabled:opacity-50 mr-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-10 h-10 font-medium text-blue-600 text-sm whitespace-nowrap transition-colors hover:text-accent-foreground disabled:pointer-events-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $berita->slug])) }}"
                                    target="_blank"
                                    class="inline-flex justify-center items-center hover:bg-accent disabled:opacity-50 mr-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-10 h-10 font-medium text-blue-400 text-sm whitespace-nowrap transition-colors hover:text-accent-foreground disabled:pointer-events-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>

                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $berita->slug])) }}"
                                    target="_blank"
                                    class="inline-flex justify-center items-center hover:bg-accent disabled:opacity-50 mr-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-10 h-10 font-medium text-green-500 text-sm whitespace-nowrap transition-colors hover:text-accent-foreground disabled:pointer-events-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm0 10.538c-1.151 0-1.822-.404-2.884-.962l-2.051.538.549-2.006c-.606-1.035-.956-1.734-.956-2.774.002-2.632 2.156-4.778 4.788-4.778 2.631 0 4.786 2.147 4.788 4.779-.002 2.632-2.157 4.778-4.788 4.778 0-.001 0-.001 0 0zm2.918-3.585c-.144-.066-1.848-.913-2.135-.912-.285.001-.435.128-.6.384-.165.256-.629.84-.772.968-.144.127-.288.169-.519.091-.231-.078-1.099-.405-2.095-1.291-.775-.694-1.3-1.553-1.451-1.815-.153-.262-.018-.405.115-.535.118-.118.24-.309.36-.464.121-.155.151-.262.225-.435.075-.173.039-.323-.018-.451-.057-.128-.519-1.251-.713-1.706-.19-.478-.384-.414-.529-.421-.136-.007-.24-.044-.371-.044s-.336.154-.504.39c-.17.237-.645.645-.645 1.542s.658 1.784.757 1.912c.099.127 1.39 2.119 3.363 2.95.47.203.84.326 1.129.417.475.152.908.142 1.244.082.38-.06 1.171-.479 1.331-.942.162-.464.155-.86.108-.944-.057-.084-.195-.133-.427-.231z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>

                                <button
                                    onclick="copyToClipboard('{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $berita->slug]) }}')"
                                    class="inline-flex justify-center items-center hover:bg-accent disabled:opacity-50 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-10 h-10 font-medium text-muted-foreground text-sm whitespace-nowrap transition-colors hover:text-accent-foreground disabled:pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="lg:col-span-1">
                <!-- Sidebar -->
                <div class="bg-card shadow-sm mb-6 p-6 border border-border rounded-lg">
                    <h3 class="mb-4 font-semibold text-card-foreground text-xl">Berita Terkait</h3>

                    @if ($related->count() > 0)
                        <div class="space-y-4">
                            @foreach ($related as $item)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-secondary rounded-md w-16 h-16 overflow-hidden">
                                        @if ($item->getFirstMediaUrl('thumbnail'))
                                            <img src="{{ $item->getFirstMediaUrl('thumbnail') }}"
                                                alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-medium text-card-foreground text-sm">
                                            <a href="{{ route('desa.berita.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                                                class="hover:text-primary">
                                                {{ Str::limit($item->judul, 60) }}
                                            </a>
                                        </h4>
                                        <p class="text-muted-foreground text-xs">
                                            {{ $item->published_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted-foreground">Tidak ada berita terkait.</p>
                    @endif
                </div>

                <div class="bg-card shadow-sm p-6 border border-border rounded-lg">
                    <h3 class="mb-4 font-semibold text-card-foreground text-xl">Kategori</h3>
                    <div class="space-y-2">
                        <a href="{{ route('desa.berita', ['uri' => $desa->uri, 'kategori' => 'berita']) }}"
                            class="block hover:bg-accent px-3 py-2 rounded-md text-card-foreground hover:text-accent-foreground">
                            Berita
                        </a>
                        <a href="{{ route('desa.berita', ['uri' => $desa->uri, 'kategori' => 'pengumuman']) }}"
                            class="block hover:bg-accent px-3 py-2 rounded-md text-card-foreground hover:text-accent-foreground">
                            Pengumuman
                        </a>
                        <a href="{{ route('desa.berita', ['uri' => $desa->uri, 'kategori' => 'kegiatan']) }}"
                            class="block hover:bg-accent px-3 py-2 rounded-md text-card-foreground hover:text-accent-foreground">
                            Kegiatan
                        </a>
                        <a href="{{ route('desa.berita', ['uri' => $desa->uri, 'kategori' => 'program']) }}"
                            class="block hover:bg-accent px-3 py-2 rounded-md text-card-foreground hover:text-accent-foreground">
                            Program
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Create a toast message
                const toast = document.createElement('div');
                toast.className =
                    'fixed bottom-24 left-4 z-50 bg-green-500 text-white p-4 rounded-lg shadow-lg max-w-xs';
                toast.innerHTML = `
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>URL berhasil disalin!</span>
                </div>
            `;
                document.body.appendChild(toast);

                // Automatically remove the toast after 3 seconds
                setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity 1s';
                    setTimeout(function() {
                        document.body.removeChild(toast);
                    }, 1000);
                }, 3000);
            }).catch(function(err) {
                console.error('Gagal menyalin: ', err);
            });
        }
    </script>
@endsection
