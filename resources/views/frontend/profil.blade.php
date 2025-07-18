@php
    use App\Enums\ProfilDesaJenis;
@endphp

@extends('frontend.layouts.app')

@section('title', 'Profil Desa - ' . $desa->nama_lengkap)

@section('content')
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        {{-- Header Section --}}
        <section class="bg-gradient-to-r from-green-600 to-green-800 py-16 text-white">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4 font-bold text-4xl md:text-5xl">
                        Profil {{ $desa->nama_lengkap }}
                    </h1>
                    <p class="opacity-90 text-xl">
                        Selamat datang di {{ $desa->nama_lengkap }}
                    </p>
                </div>
            </div>
        </section>

        {{-- Main Content --}}
        <section class="py-16">
            <div class="mx-auto px-4 container">
                <div class="mx-auto max-w-4xl">
                    {{-- Navigation Links --}}
                    <div class="mb-8 border-gray-200 dark:border-gray-700 border-b">
                        <nav class="flex space-x-8" aria-label="Tabs">
                            <a href="{{ route('desa.profil', ['uri' => $desa->uri, 'jenis' => ProfilDesaJenis::TENTANG->value]) }}"
                                class="px-1 py-2 border-b-2 font-medium text-sm whitespace-nowrap {{ $jenis == ProfilDesaJenis::TENTANG->value ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400' }}">
                                Tentang {{ $desa->nama_lengkap }}
                            </a>
                            <a href="{{ route('desa.profil', ['uri' => $desa->uri, 'jenis' => ProfilDesaJenis::VISI_MISI->value]) }}"
                                class="px-1 py-2 border-b-2 font-medium text-sm whitespace-nowrap {{ $jenis == ProfilDesaJenis::VISI_MISI->value ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400' }}">
                                Visi & Misi
                            </a>
                            <a href="{{ route('desa.profil', ['uri' => $desa->uri, 'jenis' => ProfilDesaJenis::STRUKTUR->value]) }}"
                                class="px-1 py-2 border-b-2 font-medium text-sm whitespace-nowrap {{ $jenis == ProfilDesaJenis::STRUKTUR->value ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400' }}">
                                Struktur Organisasi
                            </a>
                            @if ($monografi && $monografi->count() > 0)
                                <a href="{{ route('desa.profil', ['uri' => $desa->uri, 'jenis' => ProfilDesaJenis::MONOGRAFI->value]) }}"
                                    class="px-1 py-2 border-b-2 font-medium text-sm whitespace-nowrap {{ $jenis == ProfilDesaJenis::MONOGRAFI->value ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-300 dark:text-gray-400' }}">
                                    Monografi
                                </a>
                            @endif
                        </nav>
                    </div>

                    {{-- Content --}}
                    <div class="bg-white dark:bg-gray-800 shadow-lg p-8 rounded-lg">
                        @if ($currentProfile)
                            <h2 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">
                                {{ $currentProfile->judul }}
                            </h2>
                            <div class="dark:prose-invert max-w-none prose">
                                {!! $currentProfile->konten !!}
                            </div>

                            {{-- Display media if it's a single profile entry --}}
                            @if ($currentProfile->hasMedia('documents'))
                                <div class="mt-6">
                                    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white text-lg">
                                        Dokumen Terkait
                                    </h3>
                                    <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                                        @foreach ($currentProfile->getMedia('documents') as $media)
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
                        @elseif ($jenis == ProfilDesaJenis::MONOGRAFI->value && $monografi && $monografi->count() > 0)
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
                        @else
                            <p>Konten tidak ditemukan.</p>
                        @endif
                    </div>
                    <div>
                        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white text-lg">
                            Kode Desa
                        </h3>
                        <p class="mb-4 text-gray-600 dark:text-gray-300">
                            {{ $desa->kode_desa }}
                        </p>
                    </div>
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

    </div>
    </section>
    </div>
@endsection
