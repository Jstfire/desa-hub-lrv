@extends('frontend.desa.layouts.main')

@section('title', 'Informasi ' . ucfirst(str_replace('_', ' ', $jenis)) . ' - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="font-bold text-gray-900 dark:text-white text-2xl">{{ ucfirst(str_replace('_', ' ', $jenis)) }}
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400">{{ $desa->nama }}</p>
                </div>
            </div>

            <div class="gap-6 grid grid-cols-1">
                @forelse ($metadata as $item)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="mb-3 font-semibold text-gray-900 dark:text-white text-xl">{{ $item->judul }}</h2>

                            @if ($item->getFirstMedia('gambar'))
                                <div class="mb-4">
                                    <img src="{{ $item->getFirstMediaUrl('gambar') }}" alt="{{ $item->judul }}"
                                        class="rounded w-full h-64 object-cover">
                                </div>
                            @endif

                            <div class="dark:prose-invert mb-4 max-w-none prose">
                                {!! $item->konten !!}
                            </div>

                            @if ($item->getMedia('lampiran')->count() > 0)
                                <div class="mt-6 pt-4 border-gray-200 dark:border-gray-700 border-t">
                                    <h3 class="mb-2 font-medium text-gray-900 dark:text-white text-lg">Dokumen Lampiran</h3>
                                    <div class="space-y-2">
                                        @foreach ($item->getMedia('lampiran') as $media)
                                            <div class="flex items-center space-x-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ $media->file_name }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 shadow-md p-6 rounded-lg">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada informasi {{ str_replace('_', ' ', $jenis) }}
                            yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $metadata->links() }}
            </div>
        </div>
    </div>
@endsection
