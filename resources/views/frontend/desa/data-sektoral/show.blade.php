@extends('frontend.desa.layouts.main')

@section('title', $data->judul . ' - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('desa.index', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary-600 dark:hover:text-white dark:text-gray-300">
                        <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                            class="ml-1 md:ml-2 text-gray-700 hover:text-primary-600 dark:hover:text-white dark:text-gray-300">Data
                            Sektoral</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span
                            class="ml-1 md:ml-2 text-gray-500 dark:text-gray-400">{{ Str::limit($data->judul, 40) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="relative">
                <div class="bg-gray-200 dark:bg-gray-700 h-64">
                    @if ($data->getFirstMediaUrl('thumbnail'))
                        <img src="{{ $data->getFirstMediaUrl('thumbnail') }}" alt="{{ $data->judul }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="flex justify-center items-center w-full h-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="top-4 right-4 absolute">
                    <span
                        class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                    {{ $data->sektor == 'kependudukan' ? 'bg-blue-500' : '' }}
                    {{ $data->sektor == 'kesehatan' ? 'bg-green-500' : '' }}
                    {{ $data->sektor == 'pendidikan' ? 'bg-indigo-500' : '' }}
                    {{ $data->sektor == 'ekonomi' ? 'bg-yellow-500' : '' }}
                    {{ $data->sektor == 'pertanian' ? 'bg-red-500' : '' }}
                    {{ $data->sektor == 'infrastruktur' ? 'bg-gray-500' : '' }}
                    {{ $data->sektor == 'lainnya' ? 'bg-purple-500' : '' }}
                    text-white">
                        {{ ucfirst($data->sektor) }}
                    </span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="mb-4 font-bold text-gray-900 dark:text-white text-3xl">
                        {{ $data->judul }}
                    </h1>

                    <div class="flex flex-wrap gap-4 text-gray-600 dark:text-gray-400 text-sm">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $data->published_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Tahun {{ $data->tahun }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>{{ $data->view_count }} dilihat</span>
                        </div>
                    </div>
                </div>

                @if ($data->deskripsi)
                    <div class="mb-8">
                        <h3 class="mb-3 font-semibold text-gray-800 dark:text-gray-200 text-xl">Deskripsi</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $data->deskripsi }}</p>
                    </div>
                @endif

                <!-- Data Section -->
                @if (!empty($data->data) && count($data->data) > 0)
                    <div class="mb-8">
                        <h3 class="mb-3 font-semibold text-gray-800 dark:text-gray-200 text-xl">Data Statistik</h3>

                        <div class="overflow-x-auto">
                            <table class="divide-y divide-gray-200 dark:divide-gray-700 min-w-full">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                                            Indikator
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                                            Nilai
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 font-medium text-gray-500 dark:text-gray-300 text-xs text-left uppercase tracking-wider">
                                            Satuan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($data->data as $item)
                                        <tr>
                                            <td
                                                class="px-6 py-4 text-gray-800 dark:text-gray-200 text-sm whitespace-nowrap">
                                                {{ $item['label'] ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium text-gray-900 dark:text-white text-sm whitespace-nowrap">
                                                {{ $item['value'] ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm whitespace-nowrap">
                                                {{ $item['satuan'] ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- File Download Section -->
                @if ($data->getFirstMediaUrl('dokumen'))
                    <div class="mt-8 pt-6 border-gray-200 dark:border-gray-700 border-t">
                        <h3 class="mb-3 font-semibold text-gray-800 dark:text-gray-200 text-xl">Dokumen Pendukung</h3>

                        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mr-3 w-10 h-10 text-gray-500 dark:text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white text-sm">Dokumen
                                        {{ $data->judul }}</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs">
                                        @php
                                            $media = $data->getFirstMedia('dokumen');
                                            $fileSize = $media ? number_format($media->size / 1024, 2) . ' KB' : '';
                                            $fileType = $media ? strtoupper($media->extension) : '';
                                        @endphp
                                        {{ $fileType }} • {{ $fileSize }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ $data->getFirstMediaUrl('dokumen') }}" target="_blank"
                                class="flex items-center bg-primary-600 hover:bg-primary-700 px-4 py-2 rounded-md text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
