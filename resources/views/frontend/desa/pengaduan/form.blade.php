@extends('frontend.desa.layouts.main')

@section('title', 'Form Pengaduan - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mx-auto max-w-3xl">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h2 class="mb-2 font-bold text-gray-800 dark:text-white text-3xl">Layanan Pengaduan</h2>
                <p class="text-gray-600 dark:text-gray-300">
                    Sampaikan pengaduan, keluhan, atau masukan Anda untuk
                    {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
                </p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-100 mb-6 px-4 py-3 border border-green-400 rounded text-green-700" data-auto-hide="5000">
                    <div class="flex">
                        <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 mb-6 px-4 py-3 border border-red-400 rounded text-red-700" data-auto-hide="5000">
                    <div class="flex">
                        <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Card form -->
            <div class="bg-white dark:bg-gray-800 shadow-md p-6 rounded-lg">
                <form action="{{ route('desa.pengaduan.store', $desa->uri) }}" method="POST" data-toast-submit>
                    @csrf

                    <!-- Informasi Pengadu -->
                    <div class="mb-6">
                        <h3
                            class="mb-4 pb-2 border-gray-200 dark:border-gray-700 border-b font-semibold text-gray-800 dark:text-gray-200 text-lg">
                            Informasi Pengirim
                        </h3>

                        <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                            <div class="mb-4">
                                <label for="nama"
                                    class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Nama Lengkap
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                    class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white"
                                    required>
                                @error('nama')
                                    <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email"
                                    class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="telepon"
                                    class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Nomor
                                    Telepon</label>
                                <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                    class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white">
                                @error('telepon')
                                    <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pengaduan -->
                    <div class="mb-6">
                        <h3
                            class="mb-4 pb-2 border-gray-200 dark:border-gray-700 border-b font-semibold text-gray-800 dark:text-gray-200 text-lg">
                            Detail Pengaduan
                        </h3>

                        <div class="mb-4">
                            <label for="judul"
                                class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Judul Pengaduan
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white"
                                required>
                            @error('judul')
                                <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="isi"
                                class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Isi Pengaduan <span
                                    class="text-red-500">*</span></label>
                            <textarea id="isi" name="isi" rows="5"
                                class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white"
                                required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="lampiran"
                                class="block mb-2 font-medium text-gray-700 dark:text-gray-300 text-sm">Link Lampiran
                                (opsional)</label>
                            <input type="url" id="lampiran" name="lampiran" value="{{ old('lampiran') }}"
                                class="dark:bg-gray-700 shadow-sm px-3 py-2 border border-gray-300 focus:border-primary-500 dark:border-gray-600 rounded-md focus:outline-none focus:ring-primary-500 w-full dark:text-white"
                                placeholder="https://drive.google.com/file/...">
                            <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm">Masukkan link Google Drive, Dropbox,
                                dll untuk melampirkan file</p>
                            @error('lampiran')
                                <p class="mt-1 text-red-600 dark:text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-8">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">
                            <span class="text-red-500">*</span> Wajib diisi
                        </div>
                        <button type="submit"
                            class="bg-primary-600 hover:bg-primary-700 px-6 py-3 rounded-md font-medium text-white transition-colors">
                            Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-blue-50 dark:bg-gray-700/50 mt-8 p-6 rounded-lg">
                <h3 class="mb-4 font-semibold text-gray-800 dark:text-gray-200 text-lg">
                    Informasi Pengaduan
                </h3>
                <div class="space-y-2 text-gray-600 dark:text-gray-300 text-sm">
                    <p>1. Pengaduan Anda akan diproses dalam 3-5 hari kerja.</p>
                    <p>2. Tim kami akan menghubungi Anda melalui email atau telepon yang telah diberikan.</p>
                    <p>3. Mohon untuk memberikan informasi yang akurat dan lengkap agar pengaduan dapat ditindaklanjuti
                        dengan baik.</p>
                    <p>4. Untuk pengaduan darurat, silakan hubungi langsung ke nomor telepon
                        {{ $desa->telepon ?? 'kantor desa' }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
