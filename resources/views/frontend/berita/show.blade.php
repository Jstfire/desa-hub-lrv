@extends('frontend.layouts.app')

@section('title', $berita->judul . ' - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-12 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl">
                    <nav class="flex items-center mb-4 text-blue-100 text-sm">
                        <a href="{{ route('desa.beranda', $desa->uri) }}" class="hover:text-white">
                            Beranda
                        </a>
                        <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('desa.berita', $desa->uri) }}" class="hover:text-white">
                            Berita
                        </a>
                        <svg class="mx-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-blue-200">{{ $berita->judul }}</span>
                    </nav>

                    <h1 class="mb-4 font-bold text-3xl md:text-4xl">
                        {{ $berita->judul }}
                    </h1>

                    <div class="flex items-center space-x-4 text-blue-100">
                        <div class="flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a4 4 0 118 0v4m-4 8v2m-2 4h4m-4 0h8a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                            </svg>
                            {{ $berita->tanggal_publikasi->format('d F Y') }}
                        </div>
                        <div class="flex items-center">
                            <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $berita->views }} kali dibaca
                        </div>
                        @if ($berita->penulis)
                            <div class="flex items-center">
                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $berita->penulis }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl">
                    {{-- Featured Image --}}
                    @if ($berita->getFirstMediaUrl('featured_image'))
                        <img src="{{ $berita->getFirstMediaUrl('featured_image') }}" alt="{{ $berita->judul }}"
                            class="shadow-lg mb-8 rounded-lg w-full h-96 object-cover">
                    @endif

                    {{-- Content --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg mb-8 p-8 rounded-lg">
                        <div class="dark:prose-invert max-w-none prose prose-lg">
                            {!! $berita->konten !!}
                        </div>
                    </div>

                    {{-- Tags --}}
                    @if ($berita->tags)
                        <div class="mb-8">
                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                                Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach (explode(',', $berita->tags) as $tag)
                                    <span
                                        class="inline-flex items-center bg-blue-100 dark:bg-blue-900 px-3 py-1 rounded-full font-medium text-blue-800 dark:text-blue-200 text-sm">
                                        {{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Share Buttons --}}
                    <div class="mb-8">
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                            Bagikan
                        </h3>
                        <div class="flex space-x-4">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md font-medium text-white text-sm transition-colors duration-200">
                                <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}"
                                target="_blank"
                                class="inline-flex items-center bg-blue-400 hover:bg-blue-500 px-4 py-2 rounded-md font-medium text-white text-sm transition-colors duration-200">
                                <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->url()) }}"
                                target="_blank"
                                class="inline-flex items-center bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md font-medium text-white text-sm transition-colors duration-200">
                                <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                </svg>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    {{-- Related News --}}
                    @if ($beritaTerkait->count() > 0)
                        <div class="mb-8">
                            <h3 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                                Berita Terkait
                            </h3>
                            <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
                                @foreach ($beritaTerkait as $item)
                                    <a href="{{ route('desa.berita.show', [$desa->uri, $item->slug]) }}"
                                        class="block bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl rounded-lg overflow-hidden transition-shadow duration-300">
                                        @if ($item->getFirstMediaUrl('featured_image'))
                                            <img src="{{ $item->getFirstMediaUrl('featured_image') }}"
                                                alt="{{ $item->judul }}" class="w-full h-48 object-cover">
                                        @else
                                            <div
                                                class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 w-full h-48">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="p-6">
                                            <h4 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                                {{ $item->judul }}
                                            </h4>
                                            <p class="mb-2 text-gray-600 dark:text-gray-300 text-sm">
                                                {{ Str::limit(strip_tags($item->konten), 100) }}
                                            </p>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3a4 4 0 118 0v4m-4 8v2m-2 4h4m-4 0h8a2 2 0 002-2v-4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z" />
                                                </svg>
                                                {{ $item->tanggal_publikasi->format('d M Y') }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
