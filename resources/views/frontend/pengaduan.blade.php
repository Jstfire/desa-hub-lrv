@extends('frontend.layouts.app')

@section('title', 'Pengaduan')
@section('description', 'Sampaikan pengaduan dan aspirasi Anda kepada ' . ($desa->jenis == 'desa' ? 'Desa' :
    'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <!-- Header -->
    <section class="bg-primary py-16 text-white">
        <div class="mx-auto px-4 container">
            <div class="text-center">
                <h1 class="mb-4 font-bold text-4xl">Pengaduan & Aspirasi</h1>
                <p class="text-xl">Sampaikan pengaduan, aspirasi, dan saran Anda kepada
                    {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}</p>
            </div>
        </div>
    </section>

    <!-- Form Pengaduan -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="mx-auto px-4 container">
            <div class="mx-auto max-w-3xl">
                <div class="bg-white dark:bg-gray-900 shadow-lg p-8 rounded-lg">
                    <div class="mb-8 text-center">
                        <div
                            class="flex justify-center items-center bg-primary mx-auto mb-4 rounded-full w-16 h-16 text-white">
                            <i class="text-2xl fas fa-comment-dots"></i>
                        </div>
                        <h2 class="mb-2 font-bold text-gray-800 dark:text-white text-2xl">Form Pengaduan</h2>
                        <p class="text-gray-600 dark:text-gray-400">Isi form di bawah ini untuk menyampaikan pengaduan atau
                            aspirasi Anda</p>
                    </div>

                    <form action="{{ route('desa.pengaduan.store', $desa->uri) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Masukkan nama lengkap Anda" required>
                            @error('nama')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Masukkan alamat email Anda" required>
                            @error('email')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor Telepon -->
                        <div>
                            <label for="telepon" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Nomor Telepon/WhatsApp
                            </label>
                            <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Contoh: 081234567890">
                            @error('telepon')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Judul Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Masukkan judul pengaduan Anda" required>
                            @error('judul')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="isi" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Deskripsi Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="isi" name="isi" rows="6"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Jelaskan pengaduan Anda secara detail..." required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lampiran -->
                        <div>
                            <label for="lampiran" class="block mb-2 font-semibold text-gray-700 dark:text-gray-300 text-sm">
                                Lampiran (Opsional)
                            </label>
                            <input type="url" id="lampiran" name="lampiran" value="{{ old('lampiran') }}"
                                class="dark:bg-gray-800 px-4 py-3 border border-gray-300 dark:border-gray-600 focus:border-transparent rounded-lg focus:ring-2 focus:ring-primary w-full dark:text-white"
                                placeholder="Link Google Drive file pendukung (jika ada)">
                            <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm">
                                Jika ada file pendukung, silakan upload ke Google Drive dan masukkan link-nya di sini
                            </p>
                            @error('lampiran')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 text-center">
                            <button type="submit"
                                class="flex justify-center items-center bg-primary hover:bg-opacity-90 px-8 py-3 rounded-lg w-full sm:w-auto font-semibold text-white transition-colors">
                                <i class="mr-2 fas fa-paper-plane"></i>
                                Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi Kontak -->
    <section class="bg-white dark:bg-gray-900 py-16">
        <div class="mx-auto px-4 container">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Informasi Kontak</h2>
                <p class="text-gray-600 dark:text-gray-400">Anda juga dapat menghubungi kami melalui kontak di bawah ini</p>
            </div>

            <div class="gap-8 grid grid-cols-1 md:grid-cols-3">
                <!-- Telepon -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg text-center">
                    <div class="flex justify-center items-center bg-primary mx-auto mb-4 rounded-full w-16 h-16 text-white">
                        <i class="text-2xl fas fa-phone"></i>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-xl">Telepon</h3>
                    <p class="text-gray-600 dark:text-gray-400">0123-456-789</p>
                    <a href="tel:0123456789" class="font-semibold text-primary hover:underline">Hubungi Sekarang</a>
                </div>

                <!-- WhatsApp -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg text-center">
                    <div
                        class="flex justify-center items-center bg-green-500 mx-auto mb-4 rounded-full w-16 h-16 text-white">
                        <i class="text-2xl fab fa-whatsapp"></i>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-xl">WhatsApp</h3>
                    <p class="text-gray-600 dark:text-gray-400">081234567890</p>
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="font-semibold text-green-500 hover:underline">Chat WhatsApp</a>
                </div>

                <!-- Email -->
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg text-center">
                    <div
                        class="flex justify-center items-center bg-blue-500 mx-auto mb-4 rounded-full w-16 h-16 text-white">
                        <i class="text-2xl fas fa-envelope"></i>
                    </div>
                    <h3 class="mb-2 font-semibold text-gray-800 dark:text-white text-xl">Email</h3>
                    <p class="text-gray-600 dark:text-gray-400">info@{{ $desa - > uri }}.desa.id</p>
                    <a href="mailto:info@{{ $desa - > uri }}.desa.id"
                        class="font-semibold text-blue-500 hover:underline">Kirim Email</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="mx-auto px-4 container">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-bold text-gray-800 dark:text-white text-3xl">Pertanyaan Umum</h2>
                <p class="text-gray-600 dark:text-gray-400">Beberapa pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-6 mx-auto max-w-3xl">
                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg">
                    <h3 class="mb-3 font-semibold text-gray-800 dark:text-white text-lg">
                        <i class="mr-2 text-primary fas fa-question-circle"></i>
                        Berapa lama waktu respon pengaduan?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Kami akan merespon pengaduan Anda maksimal dalam 3x24 jam kerja.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg">
                    <h3 class="mb-3 font-semibold text-gray-800 dark:text-white text-lg">
                        <i class="mr-2 text-primary fas fa-question-circle"></i>
                        Apakah ada biaya untuk mengajukan pengaduan?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Tidak ada biaya apapun. Layanan pengaduan ini gratis untuk seluruh masyarakat.
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-6 rounded-lg">
                    <h3 class="mb-3 font-semibold text-gray-800 dark:text-white text-lg">
                        <i class="mr-2 text-primary fas fa-question-circle"></i>
                        Bagaimana cara mengetahui status pengaduan saya?
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Kami akan menghubungi Anda melalui nomor telepon/WhatsApp yang Anda berikan untuk memberikan update
                        status pengaduan.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Auto-format phone number
        document.getElementById('nomor_telepon').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            // Add +62 prefix if it starts with 0
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            }

            // Format with dashes for readability
            if (value.length > 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }
            if (value.length > 7) {
                value = value.substring(0, 7) + '-' + value.substring(7);
            }
            if (value.length > 11) {
                value = value.substring(0, 11) + '-' + value.substring(11);
            }

            e.target.value = value;
        });
    </script>
@endpush
