@extends('frontend.layouts.app')

@section('title', $item->judul . ' - ' . $desa->nama)

@section('content')
    <div class="bg-gray-50 py-8 min-h-screen">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Header -->
            <div class="bg-white shadow-sm mb-6 p-6 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('desa.publikasi', $desa->uri) }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>

                    @if ($type === 'ppid')
                        <span
                            class="inline-flex items-center bg-blue-100 px-3 py-1 rounded-full font-medium text-blue-800 text-sm">
                            PPID
                        </span>
                    @elseif($type === 'publikasi')
                        <span
                            class="inline-flex items-center bg-green-100 px-3 py-1 rounded-full font-medium text-green-800 text-sm">
                            Publikasi
                        </span>
                    @elseif($type === 'metadata')
                        <span
                            class="inline-flex items-center bg-purple-100 px-3 py-1 rounded-full font-medium text-purple-800 text-sm">
                            Metadata
                        </span>
                    @elseif($type === 'data-sektoral')
                        <span
                            class="inline-flex items-center bg-orange-100 px-3 py-1 rounded-full font-medium text-orange-800 text-sm">
                            Data Sektoral
                        </span>
                    @endif
                </div>

                <h1 class="mb-2 font-bold text-gray-900 text-3xl">{{ $item->judul }}</h1>

                <div class="flex items-center space-x-4 text-gray-500 text-sm">
                    <span>{{ $item->created_at->format('d M Y') }}</span>
                    @if (isset($item->kategori))
                        <span>•</span>
                        <span>{{ ucfirst($item->kategori) }}</span>
                    @endif
                    @if (isset($item->jenis))
                        <span>•</span>
                        <span>{{ ucfirst($item->jenis) }}</span>
                    @endif
                </div>
            </div>

            <!-- Main Download Button -->
            @php
            $documents = collect();
            if($type === 'ppid' || $type === 'publikasi' || $type === 'data-sektoral' || $type === 'metadata') {
                $documents = $item->getMedia('dokumen');
            }
        @endphp

            @if ($documents->count() > 0)
                <div class="bg-white shadow-sm mb-6 p-6 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">Dokumen Utama</h3>
                            <p class="mt-1 text-gray-500 text-sm">{{ $documents->first()->name }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if (strtolower(pathinfo($documents->first()->name, PATHINFO_EXTENSION)) === 'pdf')
                                <a href="{{ $documents->first()->getUrl() }}" target="_blank"
                                    class="inline-flex items-center bg-white hover:bg-gray-50 shadow-sm px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-gray-700 text-sm">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Preview
                                </a>
                            @endif
                            <a href="{{ $documents->first()->getUrl() }}" download
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-white text-sm">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Download Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="bg-white shadow-sm mb-6 p-6 rounded-lg">
                @if (isset($item->konten) && $item->konten)
                    <div class="max-w-none prose">
                        {!! $item->konten !!}
                    </div>
                @elseif(isset($item->deskripsi) && $item->deskripsi)
                    <div class="max-w-none prose">
                        {!! $item->deskripsi !!}
                    </div>
                @else
                    <p class="text-gray-500 italic">Tidak ada konten yang tersedia.</p>
                @endif
            </div>

            <!-- Documents/Files -->
            @if ($documents->count() > 1)
                <div class="bg-white shadow-sm p-6 rounded-lg">
                    <h3 class="mb-4 font-semibold text-gray-900 text-lg">Semua Dokumen</h3>
                    <div class="space-y-3">
                        @foreach ($documents as $document)
                            <div
                                class="flex justify-between items-center hover:bg-gray-50 p-4 border border-gray-200 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @php
                                            $extension = strtolower(pathinfo($document->name, PATHINFO_EXTENSION));
                                        @endphp
                                        @if (in_array($extension, ['pdf']))
                                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif(in_array($extension, ['doc', 'docx']))
                                            <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @elseif(in_array($extension, ['xls', 'xlsx']))
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"></path>
                                        </svg>
                                        @else
                                            <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 text-sm">{{ $document->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ $document->human_readable_size }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if (in_array($extension, ['pdf']))
                                        <a href="{{ $document->getUrl() }}" target="_blank"
                                            class="inline-flex items-center bg-white hover:bg-gray-50 shadow-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-gray-700 text-sm leading-4">
                                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Preview
                                        </a>
                                    @elseif(in_array($extension, ['xls', 'xlsx']))
                                        <a href="{{ $document->getUrl() }}" target="_blank"
                                            class="inline-flex items-center bg-white hover:bg-gray-50 shadow-sm px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-gray-700 text-sm leading-4">
                                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            Buka
                                        </a>
                                    @endif
                                    <a href="{{ $document->getUrl() }}" download
                                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-3 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium text-white text-sm leading-4">
                                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- PDF Preview Section -->
            @if ($documents->count() > 0)
                @php
                    $firstDocument = $documents->first();
                    $fileName = $firstDocument->name;
                    $mimeType = $firstDocument->mime_type;

                    // Try multiple methods to get extension
                    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                    // If pathinfo fails, try to get from mime type
                 if (empty($extension) && $mimeType) {
                     if (strpos($mimeType, 'pdf') !== false) {
                         $extension = 'pdf';
                     } elseif (strpos($mimeType, 'word') !== false || strpos($mimeType, 'msword') !== false) {
                         $extension = 'doc';
                     } elseif (strpos($mimeType, 'excel') !== false || strpos($mimeType, 'spreadsheet') !== false) {
                         $extension = 'xlsx';
                     }
                 }

                    // If still empty, try to extract from file name manually
                    if (empty($extension) && strpos($fileName, '.') !== false) {
                        $parts = explode('.', $fileName);
                        $extension = strtolower(end($parts));
                    }

                    $documentUrl = $firstDocument->getUrl();
                    $isPdf = $extension === 'pdf' || strpos($mimeType, 'pdf') !== false;
                @endphp



                @if ($isPdf)
                    <div class="bg-white shadow-sm mt-6 p-6 rounded-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-900 text-lg">Preview Dokumen PDF</h3>
                            <div class="text-gray-500 text-sm">
                                <span
                                    class="inline-flex items-center bg-red-100 px-2 py-1 rounded-full font-medium text-red-800 text-xs">
                                    PDF
                                </span>
                            </div>
                        </div>

                        <!-- PDF Viewer -->
                        <div class="relative bg-gray-100 rounded-lg w-full overflow-hidden" style="height: 700px;">
                            <iframe src="{{ $documentUrl }}#toolbar=1&navpanes=1&scrollbar=1"
                                class="border-0 w-full h-full" title="Preview {{ $firstDocument->name }}"
                                frameborder="0" allowfullscreen>
                                <div class="flex justify-center items-center h-full">
                                    <div class="text-center">
                                        <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="mb-2 text-gray-500">Browser Anda tidak mendukung preview PDF.</p>
                                        <a href="{{ $documentUrl }}" target="_blank"
                                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 border border-transparent rounded-md font-medium text-white text-sm">
                                            Buka Dokumen
                                        </a>
                                    </div>
                                </div>
                            </iframe>
                        </div>

                        <!-- Alternative PDF viewer using embed -->
                        <div class="bg-gray-50 mt-4 p-4 rounded-lg">
                            <p class="mb-2 text-gray-600 text-sm">Jika preview di atas tidak muncul, coba alternatif
                                berikut:</p>
                            <div class="flex space-x-2">
                                <a href="{{ $documentUrl }}" target="_blank"
                                    class="inline-flex items-center bg-white hover:bg-gray-50 shadow-sm px-3 py-2 border border-gray-300 rounded-md font-medium text-gray-700 text-sm leading-4">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                    Buka di Tab Baru
                                </a>
                                <a href="{{ $documentUrl }}" download
                                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-3 py-2 border border-transparent rounded-md font-medium text-white text-sm leading-4">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Non-PDF Document Preview -->
                    <div class="bg-white shadow-sm mt-6 p-6 rounded-lg">
                        <div class="py-8 text-center">
                            <svg class="mx-auto mb-4 w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="mb-2 font-medium text-gray-900 text-lg">Preview Tidak Tersedia</h3>
                            <p class="mb-4 text-gray-500">
                                @if(in_array($extension, ['xls', 'xlsx']))
                                    File Excel tidak dapat di-preview di browser. Silakan download atau buka di aplikasi Excel.
                                @else
                                    Preview hanya tersedia untuk file PDF. Dokumen ini berformat {{ strtoupper($extension ?: 'UNKNOWN') }}.
                                @endif
                            </p>
                            <a href="{{ $documentUrl }}" download
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 border border-transparent rounded-md font-medium text-white text-sm">
                                <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Download Dokumen
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
