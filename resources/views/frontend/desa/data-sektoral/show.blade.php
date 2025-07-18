@extends('frontend.desa.layouts.main')

@section('title', $data->judul . ' - ' . $desa->nama_lengkap)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('desa.index', $desa->uri) }}"
                        class="text-muted-foreground hover:text-primary transition-colors">
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
                        <svg class="w-6 h-6 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                            class="ml-1 md:ml-2 text-muted-foreground hover:text-primary transition-colors">Data
                            Sektoral</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 md:ml-2 text-muted-foreground">{{ Str::limit($data->judul, 40) }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="relative">
                <div class="bg-muted h-64">
                    @if ($data->getFirstMediaUrl('thumbnail'))
                        <img src="{{ $data->getFirstMediaUrl('thumbnail') }}" alt="{{ $data->judul }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="flex justify-center items-center w-full h-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-muted-foreground" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="top-4 right-4 absolute">
                    <span
                        class="inline-block bg-primary/10 px-3 py-1 border border-primary/20 rounded-full font-semibold text-primary text-sm">
                        {{ ucfirst($data->sektor) }}
                    </span>
                </div>
            </div>

            <!-- Content Section -->
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="mb-4 font-bold text-card-foreground text-3xl">
                        {{ $data->judul }}
                    </h1>

                    <div class="flex flex-wrap gap-4 text-muted-foreground text-sm">
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
                        <h3 class="mb-3 font-semibold text-card-foreground text-xl">Deskripsi</h3>
                        <p class="text-muted-foreground">{{ $data->deskripsi }}</p>
                    </div>
                @endif

                <!-- Data Section -->
                <div class="mb-8">
                    <h3 class="mb-3 font-semibold text-card-foreground text-xl">Data Statistik</h3>

                    @if (!empty($data->data) && count($data->data) > 0)
                        <div class="overflow-x-auto">
                            <table class="border border-border rounded-lg min-w-full">
                                <thead class="bg-muted">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 border-b border-border font-medium text-muted-foreground text-xs text-left uppercase tracking-wider">
                                            Indikator
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 border-b border-border font-medium text-muted-foreground text-xs text-left uppercase tracking-wider">
                                            Nilai
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 border-b border-border font-medium text-muted-foreground text-xs text-left uppercase tracking-wider">
                                            Satuan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-card">
                                    @foreach ($data->data as $item)
                                        <tr class="border-b border-border last:border-b-0">
                                            <td class="px-6 py-4 text-card-foreground text-sm whitespace-nowrap">
                                                {{ $item['label'] ?? '-' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium text-card-foreground text-sm whitespace-nowrap">
                                                {{ $item['value'] ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-muted-foreground text-sm whitespace-nowrap">
                                                {{ $item['satuan'] ?? '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-muted py-8 border border-border rounded-lg text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-12 h-12 text-muted-foreground"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <h4 class="mt-2 font-medium text-foreground text-sm">Data statistik belum tersedia</h4>
                            <p class="mt-1 text-muted-foreground text-sm">Belum ada data statistik yang dipublikasikan
                                untuk item ini.</p>
                        </div>
                    @endif
                </div>

                <!-- File Download Section -->
                <div class="mt-8 pt-6 border-t border-border">
                    <h3 class="mb-3 font-semibold text-card-foreground text-xl">Dokumen Pendukung</h3>

                    @if ($data->getFirstMediaUrl('dokumen'))
                        <div class="flex justify-between items-center bg-muted p-4 border border-border rounded-lg">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 w-10 h-10 text-muted-foreground"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-card-foreground text-sm">Dokumen
                                        {{ $data->judul }}</p>
                                    <p class="text-muted-foreground text-xs">
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
                                class="flex items-center bg-primary hover:bg-primary/90 px-4 py-2 rounded-md text-primary-foreground transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh
                            </a>
                        </div>
                    @else
                        <div class="bg-muted py-8 border border-border rounded-lg text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-12 h-12 text-muted-foreground"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h4 class="mt-2 font-medium text-foreground text-sm">Dokumen belum tersedia</h4>
                            <p class="mt-1 text-muted-foreground text-sm">Belum ada dokumen pendukung yang dipublikasikan
                                untuk item ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
