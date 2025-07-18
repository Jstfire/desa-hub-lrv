@extends('frontend.desa.layouts.main')

@section('title', 'Data Sektoral - ' . $desa->nama_lengkap)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">
                Data Sektoral {{ $desa->nama_lengkap }}
            </h1>
            <p class="text-muted-foreground">
                Informasi dan statistik sektoral terpadu {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }}
                {{ $desa->nama_lengkap }}
            </p>
        </div>

        <!-- Filter Section -->
        <div class="bg-card shadow-sm mb-8 p-4 border border-border rounded-lg">
            <form action="{{ route('desa.data-sektoral', $desa->uri) }}" method="GET" class="flex flex-wrap gap-4">
                <div class="w-full md:w-auto">
                    <label for="search" class="block mb-1 font-medium text-card-foreground text-sm">Cari</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari data..."
                        class="bg-background file:bg-transparent disabled:opacity-50 px-3 py-2 border border-input file:border-0 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full file:font-medium placeholder:text-muted-foreground text-sm file:text-sm disabled:cursor-not-allowed">
                </div>

                <div class="w-full md:w-auto">
                    <label for="sektor" class="block mb-1 font-medium text-card-foreground text-sm">Sektor</label>
                    <select id="sektor" name="sektor"
                        class="bg-background disabled:opacity-50 px-3 py-2 border border-input rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full text-sm disabled:cursor-not-allowed">
                        <option value="">Semua Sektor</option>
                        <option value="kependudukan" {{ request('sektor') == 'kependudukan' ? 'selected' : '' }}>
                            Kependudukan</option>
                        <option value="kesehatan" {{ request('sektor') == 'kesehatan' ? 'selected' : '' }}>Kesehatan
                        </option>
                        <option value="pendidikan" {{ request('sektor') == 'pendidikan' ? 'selected' : '' }}>Pendidikan
                        </option>
                        <option value="ekonomi" {{ request('sektor') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                        <option value="pertanian" {{ request('sektor') == 'pertanian' ? 'selected' : '' }}>Pertanian
                        </option>
                        <option value="infrastruktur" {{ request('sektor') == 'infrastruktur' ? 'selected' : '' }}>
                            Infrastruktur</option>
                        <option value="lainnya" {{ request('sektor') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div class="w-full md:w-auto">
                    <label for="tahun" class="block mb-1 font-medium text-card-foreground text-sm">Tahun</label>
                    <select id="tahun" name="tahun"
                        class="bg-background disabled:opacity-50 px-3 py-2 border border-input rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full text-sm disabled:cursor-not-allowed">
                        <option value="">Semua Tahun</option>
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="flex items-end w-full md:w-auto">
                    <button type="submit"
                        class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-md text-primary-foreground transition-colors">Filter</button>
                    @if (request('search') || request('sektor') || request('tahun'))
                        <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                            class="bg-secondary hover:bg-secondary/80 ml-2 px-4 py-2 rounded-md text-secondary-foreground transition-colors">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card Grid -->
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($data as $item)
                <div
                    class="bg-card shadow-sm hover:shadow-md border border-border rounded-lg overflow-hidden transition-shadow">
                    <div class="relative bg-muted h-48">
                        @if ($item->getFirstMediaUrl('thumbnail'))
                            <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex justify-center items-center w-full h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-muted-foreground"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        @endif

                        <div class="top-0 right-0 absolute mt-2 mr-2">
                            <span
                                class="inline-block bg-primary/10 px-2 py-1 border border-primary/20 rounded-md font-semibold text-primary text-xs">
                                {{ ucfirst($item->sektor) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="mb-2 font-semibold text-card-foreground text-xl">
                            <a href="{{ route('desa.data-sektoral.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                                class="hover:text-primary transition-colors">
                                {{ $item->judul }}
                            </a>
                        </h3>

                        <div class="flex items-center mb-4 text-muted-foreground text-sm">
                            <span>{{ $item->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->tahun }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->view_count }} dilihat</span>
                        </div>

                        @if ($item->deskripsi)
                            <p class="mb-4 text-muted-foreground line-clamp-3">
                                {{ Str::limit($item->deskripsi, 150) }}
                            </p>
                        @endif

                        <a href="{{ route('desa.data-sektoral.detail', ['uri' => $desa->uri, 'slug' => $item->slug]) }}"
                            class="inline-flex items-center text-primary hover:text-primary/80 transition-colors">
                            <span>Lihat Detail</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-5 h-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-12 h-12 text-muted-foreground" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="mt-2 font-medium text-foreground text-sm">Tidak ada data sektoral</h3>
                    <p class="mt-1 text-muted-foreground text-sm">Belum ada data sektoral yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $data->withQueryString()->links() }}
        </div>
    </div>
@endsection

@section('head')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
