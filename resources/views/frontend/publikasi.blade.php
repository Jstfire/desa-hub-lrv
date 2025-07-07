@extends('frontend.layouts.app')

@section('title', 'Publikasi - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-purple-600 to-purple-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Publikasi
                    </h1>
                    <p class="opacity-90 text-xl">
                        Dokumen dan publikasi resmi {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($publikasi->count() > 0)
                    <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($publikasi as $item)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <span
                                            class="inline-flex items-center bg-purple-100 dark:bg-purple-900 px-3 py-1 rounded-full font-medium text-purple-800 dark:text-purple-200 text-sm">
                                            {{ str_replace('_', ' ', ucwords($item->kategori, '_')) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ $item->tahun }}
                                        </span>
                                    </div>

                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                                        {{ $item->judul }}
                                    </h3>

                                    @if ($item->deskripsi)
                                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                                            {{ Str::limit($item->deskripsi, 100) }}
                                        </p>
                                    @endif

                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ $item->download_count }} unduhan
                                        </div>

                                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                            <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a4 4 0 118 0v4m-4 8v2m-2 4h4m-4 0h8a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                                            </svg>
                                            {{ $item->published_at->format('d M Y') }}
                                        </div>
                                    </div>

                                    @if ($item->media->count() > 0)
                                        <div class="space-y-2 mt-4">
                                            @foreach ($item->media as $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                    onclick="incrementDownload({{ $item->id }})"
                                                    class="flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 p-3 border border-gray-200 dark:border-gray-700 rounded-lg transition-colors duration-200">
                                                    <div class="flex items-center">
                                                        <svg class="mr-2 w-5 h-5 text-red-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="font-medium text-gray-900 dark:text-white text-sm">
                                                            {{ $media->name }}
                                                        </span>
                                                    </div>
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs">
                                                        {{ round($media->size / 1024, 1) }} KB
                                                    </span>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $publikasi->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Publikasi
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Publikasi dan dokumen resmi akan segera tersedia
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function incrementDownload(publikasiId) {
            fetch(`/api/publikasi/${publikasiId}/download`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection
