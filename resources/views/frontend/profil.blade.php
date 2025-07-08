@extends('frontend.layouts.app')

@section('title', 'Profil Desa - ' . $desa->nama)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-green-600 to-green-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Profil {{ $desa->nama }}
                    </h1>
                    <p class="opacity-90 text-xl">
                        Selamat datang di {{ $desa->nama }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl">
                    {{-- Navigation Tabs --}}
                    <div class="mb-8 border-gray-200 dark:border-gray-700 border-b">
                        <nav class="flex space-x-8" aria-label="Tabs">
                            <a href="#tentang"
                                class="px-1 py-2 border-green-600 border-b-2 font-medium text-green-600 text-sm whitespace-nowrap tab-link"
                                onclick="showTab('tentang')">
                                Tentang {{ $desa->nama }}
                            </a>
                            <a href="#visi-misi"
                                class="px-1 py-2 hover:border-gray-300 border-transparent border-b-2 font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400 text-sm whitespace-nowrap tab-link"
                                onclick="showTab('visi-misi')">
                                Visi & Misi
                            </a>
                            <a href="#struktur"
                                class="px-1 py-2 hover:border-gray-300 border-transparent border-b-2 font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400 text-sm whitespace-nowrap tab-link"
                                onclick="showTab('struktur')">
                                Struktur Organisasi
                            </a>
                            @if ($monografi && $monografi->count() > 0)
                                <a href="#monografi"
                                    class="px-1 py-2 hover:border-gray-300 border-transparent border-b-2 font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400 text-sm whitespace-nowrap tab-link"
                                    onclick="showTab('monografi')">
                                    Monografi
                                </a>
                            @endif
                        </nav>
                    </div>

                    {{-- Tab Content --}}
                    @if ($tentang)
                        <div id="tentang" class="tab-content">
                            <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg">
                                <h2 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                                    {{ $tentang->judul }}
                                </h2>
                                <div class="dark:prose-invert max-w-none prose">
                                    {!! $tentang->konten !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($visiMisi)
                        <div id="visi-misi" class="hidden tab-content">
                            <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg">
                                <h2 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                                    {{ $visiMisi->judul }}
                                </h2>
                                <div class="dark:prose-invert max-w-none prose">
                                    {!! $visiMisi->konten !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($struktur)
                        <div id="struktur" class="hidden tab-content">
                            <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg">
                                <h2 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                                    {{ $struktur->judul }}
                                </h2>
                                <div class="dark:prose-invert max-w-none prose">
                                    {!! $struktur->konten !!}
                                </div>

                                {{-- Tampilkan media struktur jika ada --}}
                                @if ($struktur->getFirstMedia('documents'))
                                    <div class="mt-6">
                                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                                            Dokumen Struktur Organisasi
                                        </h3>
                                        <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                                            @foreach ($struktur->getMedia('documents') as $media)
                                                <div
                                                    class="bg-gray-50 dark:bg-gray-700 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                                                            @if (str_contains($media->mime_type, 'image'))
                                                                <x-heroicon-o-photo
                                                                    class="w-6 h-6 text-green-600 dark:text-green-400" />
                                                            @else
                                                                <x-heroicon-o-document
                                                                    class="w-6 h-6 text-green-600 dark:text-green-400" />
                                                            @endif
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="font-medium text-gray-900 dark:text-white text-sm">
                                                                {{ $media->name }}
                                                            </p>
                                                            <p class="text-gray-500 dark:text-gray-400 text-xs">
                                                                {{ $media->human_readable_size }}
                                                            </p>
                                                        </div>
                                                        <a href="{{ $media->getUrl() }}" target="_blank"
                                                            class="flex items-center space-x-1 bg-green-500 hover:bg-green-600 px-3 py-2 rounded-md font-medium text-white text-sm transition-colors">
                                                            <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                                            <span>Unduh</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($monografi && $monografi->count() > 0)
                        <div id="monografi" class="hidden tab-content">
                            <div class="space-y-6">
                                @foreach ($monografi as $item)
                                    <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg">
                                        <h3 class="mb-4 font-bold text-gray-900 dark:text-white text-xl">
                                            {{ $item->judul }}
                                        </h3>
                                        <div class="dark:prose-invert max-w-none prose">
                                            {!! $item->konten !!}
                                        </div>

                                        {{-- Tampilkan media monografi jika ada --}}
                                        @if ($item->getFirstMedia('documents'))
                                            <div class="mt-6">
                                                <h4 class="mb-4 font-semibold text-gray-900 dark:text-white">
                                                    Dokumen Monografi
                                                </h4>
                                                <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                                                    @foreach ($item->getMedia('documents') as $media)
                                                        <div
                                                            class="bg-gray-50 dark:bg-gray-700 p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                            <div class="flex items-center space-x-3">
                                                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                                                                    @if (str_contains($media->mime_type, 'image'))
                                                                        <x-heroicon-o-photo
                                                                            class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                                                    @elseif (str_contains($media->mime_type, 'pdf'))
                                                                        <x-heroicon-o-document-text
                                                                            class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                                                    @else
                                                                        <x-heroicon-o-document
                                                                            class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                                                                    @endif
                                                                </div>
                                                                <div class="flex-1">
                                                                    <p
                                                                        class="font-medium text-gray-900 dark:text-white text-sm">
                                                                        {{ $media->name }}
                                                                    </p>
                                                                    <p class="text-gray-500 dark:text-gray-400 text-xs">
                                                                        {{ $media->human_readable_size }}
                                                                    </p>
                                                                </div>
                                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                                    class="flex items-center space-x-1 bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-md font-medium text-white text-sm transition-colors">
                                                                    <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                                                    <span>Unduh</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                            Kode Desa
                        </h3>
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            {{ $desa->kode_desa }}
                        </p>
                    </div>
                    @endif

                    @if ($desa->kode_kecamatan)
                        <div>
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Kode Kecamatan
                            </h3>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                {{ $desa->kode_kecamatan }}
                            </p>
                        </div>
                    @endif

                    @if ($desa->alamat)
                        <div class="md:col-span-2">
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Alamat
                            </h3>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                {{ $desa->alamat }}
                            </p>
                        </div>
                    @endif

                    @if ($desa->deskripsi)
                        <div class="md:col-span-2">
                            <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                                Deskripsi
                            </h3>
                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                {{ $desa->deskripsi }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Navigasi ke Bagian Lain --}}
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'visi_misi']) }}"
                    class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                    <div
                        class="flex justify-center items-center bg-blue-100 dark:bg-blue-900 mx-auto mb-4 rounded-full w-16 h-16">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                        Visi & Misi
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Visi dan misi {{ $desa->nama }}
                    </p>
                </a>

                <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'sejarah']) }}"
                    class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                    <div
                        class="flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mb-4 rounded-full w-16 h-16">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                        Sejarah
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Sejarah {{ $desa->nama }}
                    </p>
                </a>

                <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'demografi']) }}"
                    class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                    <div
                        class="flex justify-center items-center bg-purple-100 dark:bg-purple-900 mx-auto mb-4 rounded-full w-16 h-16">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                        Demografi
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Data kependudukan
                    </p>
                </a>

                <a href="{{ route('desa.metadata.jenis', [$desa->uri, 'struktur_organisasi']) }}"
                    class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 rounded-lg text-center transition-shadow duration-300">
                    <div
                        class="flex justify-center items-center bg-orange-100 dark:bg-orange-900 mx-auto mb-4 rounded-full w-16 h-16">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                        Struktur Organisasi
            </div>
    </div>
    </section>
    </div>

    {{-- Tab Navigation JavaScript --}}
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active styles from all tab links
            document.querySelectorAll('.tab-link').forEach(link => {
                link.classList.remove('border-green-600', 'text-green-600');
                link.classList.add('border-transparent', 'text-gray-500', 'hover:border-gray-300',
                    'hover:text-gray-700');
            });

            // Show selected tab content
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }

            // Add active styles to clicked tab link
            const selectedLink = document.querySelector(`a[href="#${tabName}"]`);
            if (selectedLink) {
                selectedLink.classList.add('border-green-600', 'text-green-600');
                selectedLink.classList.remove('border-transparent', 'text-gray-500', 'hover:border-gray-300',
                    'hover:text-gray-700');
            }
        }

        // Prevent default click behavior for tab links
        document.querySelectorAll('.tab-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });
    </script>
@endsection
