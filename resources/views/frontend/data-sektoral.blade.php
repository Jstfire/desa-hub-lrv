@extends('frontend.layouts.app')

@section('title', 'Data Sektoral - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-indigo-600 to-indigo-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Data Sektoral
                    </h1>
                    <p class="opacity-90 text-xl">
                        Data dan informasi sektoral {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                @if ($dataSektoral->count() > 0)
                    <div class="gap-8 grid grid-cols-1 lg:grid-cols-2">
                        @foreach ($dataSektoral as $data)
                            <div
                                class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow duration-300">
                                @if ($data->getFirstMediaUrl('thumbnail'))
                                    <img src="{{ $data->getFirstMediaUrl('thumbnail') }}" alt="{{ $data->judul }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="flex justify-center items-center bg-gradient-to-br from-indigo-500 to-purple-600 w-full h-48">
                                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <span
                                            class="inline-flex items-center bg-indigo-100 dark:bg-indigo-900 px-3 py-1 rounded-full font-medium text-indigo-800 dark:text-indigo-200 text-sm">
                                            {{ ucfirst($data->sektor) }}
                                        </span>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ $data->tahun }}
                                        </span>
                                    </div>

                                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">
                                        {{ $data->judul }}
                                    </h3>

                                    @if ($data->deskripsi)
                                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                                            {{ Str::limit($data->deskripsi, 100) }}
                                        </p>
                                    @endif

                                    {{-- Display Data --}}
                                    @if ($data->data && is_array($data->data) && count($data->data) > 0)
                                        <div class="mb-4">
                                            <h4 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                                Data:
                                            </h4>
                                            <div class="space-y-2">
                                                @foreach (array_slice($data->data, 0, 3) as $item)
                                                    <div
                                                        class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 p-2 rounded">
                                                        <span class="text-gray-900 dark:text-white text-sm">
                                                            {{ $item['label'] ?? '' }}
                                                        </span>
                                                        <span class="font-medium text-gray-900 dark:text-white text-sm">
                                                            {{ $item['value'] ?? '' }}
                                                            @if (isset($item['satuan']))
                                                                {{ $item['satuan'] }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach

                                                @if (count($data->data) > 3)
                                                    <div class="text-center">
                                                        <button onclick="showMoreData({{ $data->id }})"
                                                            class="font-medium text-indigo-600 hover:text-indigo-800 text-sm">
                                                            Lihat {{ count($data->data) - 3 }} data lainnya...
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    {{-- File Download --}}
                                    @if ($data->getFirstMediaUrl('dokumen'))
                                        <div class="mb-4">
                                            <a href="{{ $data->getFirstMediaUrl('dokumen') }}" target="_blank"
                                                onclick="incrementView({{ $data->id }})"
                                                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md font-medium text-white text-sm transition-colors duration-200">
                                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Unduh Dokumen
                                            </a>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                                        <span>{{ $data->view_count }} kali dilihat</span>
                                        <span>{{ $data->published_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $dataSektoral->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="mx-auto mb-4 w-24 h-24 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4" />
                        </svg>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-2xl">
                            Belum Ada Data Sektoral
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Data sektoral sedang dalam tahap pengumpulan
                        </p>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function incrementView(dataId) {
            fetch(`/api/data-sektoral/${dataId}/view`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        function showMoreData(dataId) {
            // Could implement modal or expand functionality here
            console.log('Show more data for ID:', dataId);
        }
    </script>
@endsection
