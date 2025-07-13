@props(['item', 'desa', 'view' => 'grid'])

@if ($view === 'grid')
    <div class="bg-card border border-border shadow-sm hover:shadow-md rounded-lg overflow-hidden transition-shadow">
        <div class="relative bg-muted h-48">
            @if ($item->getFirstMediaUrl('thumbnail'))
                <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                    class="w-full h-full object-cover">
            @else
                <div class="flex justify-center items-center w-full h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            @endif

            <div class="top-0 right-0 absolute mt-2 mr-2">
                <span
                    class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                    {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                    {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                    {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                    {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                    {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                    {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                    text-white">
                    {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <h3 class="mb-2 font-semibold text-card-foreground text-xl">
                {{ $item->judul }}
            </h3>

            <div class="flex items-center mb-4 text-muted-foreground text-sm">
                <span>{{ $item->published_at->format('d M Y') }}</span>
                <span class="mx-2">•</span>
                <span>{{ $item->tahun }}</span>
                <span class="mx-2">•</span>
                <span>{{ $item->download_count }} unduhan</span>
            </div>

            @if ($item->deskripsi)
                <p class="mb-4 text-muted-foreground line-clamp-3">
                    {{ Str::limit($item->deskripsi, 150) }}
                </p>
            @endif

            <a href="{{ route('desa.publikasi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Unduh Dokumen
            </a>
        </div>
    </div>
@else
    <div class="bg-card border border-border shadow-sm hover:shadow-md rounded-lg overflow-hidden transition-shadow">
        <div class="flex md:flex-row flex-col">
            <div class="relative bg-muted md:w-1/4 h-48 md:h-auto">
                @if ($item->getFirstMediaUrl('thumbnail'))
                    <img src="{{ $item->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->judul }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="flex justify-center items-center w-full h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                @endif

                <div class="md:hidden top-0 left-0 absolute mt-2 ml-2">
                    <span
                        class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                        {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                        {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                        {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                        {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                        {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                        {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                        text-white">
                        {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                    </span>
                </div>
            </div>

            <div class="p-6 md:w-3/4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="mb-2 font-semibold text-card-foreground text-xl">
                            {{ $item->judul }}
                        </h3>
                        <div class="flex items-center mb-4 text-muted-foreground text-sm">
                            <span>{{ $item->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->tahun }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $item->download_count }} unduhan</span>
                        </div>
                    </div>
                    <div class="hidden md:block ml-4">
                        <span
                            class="inline-block px-2 py-1 text-xs font-semibold rounded-md 
                            {{ $item->kategori == 'laporan_keuangan' ? 'bg-green-500' : '' }}
                            {{ $item->kategori == 'laporan_kegiatan' ? 'bg-blue-500' : '' }}
                            {{ $item->kategori == 'rencana_kerja' ? 'bg-purple-500' : '' }}
                            {{ $item->kategori == 'peraturan_desa' ? 'bg-yellow-500' : '' }}
                            {{ $item->kategori == 'transparansi' ? 'bg-red-500' : '' }}
                            {{ $item->kategori == 'lainnya' ? 'bg-gray-500' : '' }}
                            text-white">
                            {{ str_replace('_', ' ', ucfirst($item->kategori)) }}
                        </span>
                    </div>
                </div>

                @if ($item->deskripsi)
                    <p class="mb-4 text-muted-foreground line-clamp-3">
                        {{ Str::limit($item->deskripsi, 250) }}
                    </p>
                @endif

                <a href="{{ route('desa.publikasi.download', ['uri' => $desa->uri, 'id' => $item->id]) }}"
                    class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh Dokumen
                </a>
            </div>
        </div>
    </div>
@endif