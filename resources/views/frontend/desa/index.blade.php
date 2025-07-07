@extends('frontend.desa.layouts.main')

@section('title', ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <!-- Banner Section -->
    <section class="bg-gray-200 dark:bg-gray-800 mx-auto mb-12 p-8 px-4 rounded-lg container">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="mb-4 font-bold text-gray-900 dark:text-white text-4xl">
                Selamat Datang di Situs Resmi {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h2>
            <p class="text-gray-700 dark:text-gray-300 text-lg">
                {{ $desa->deskripsi ?? 'Website resmi yang menyediakan informasi terkait pemerintahan desa, kegiatan, layanan publik, dan data statistik untuk masyarakat.' }}
            </p>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="mx-auto mb-12 px-4 container">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-900 dark:text-white text-2xl">Berita Terbaru</h3>
            <a href="{{ route('desa.berita', $desa->uri) }}"
                class="text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua</a>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($beritaTerbaru as $berita)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    @if ($berita->getFirstMediaUrl('thumbnail'))
                        <div class="bg-gray-300 dark:bg-gray-700 h-48">
                            <img src="{{ $berita->getFirstMediaUrl('thumbnail') }}" alt="{{ $berita->judul }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="flex justify-center items-center bg-gray-300 dark:bg-gray-700 h-48">
                            <span class="text-gray-500 dark:text-gray-400">Tidak ada gambar</span>
                        </div>
                    @endif
                    <div class="p-6">
                        <h4 class="mb-2 font-semibold text-gray-900 dark:text-white text-xl">{{ $berita->judul }}</h4>
                        <div class="flex items-center mb-4 text-gray-500 dark:text-gray-400 text-sm">
                            <span>{{ $berita->published_at->format('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $berita->user->name }}</span>
                        </div>
                        <a href="{{ route('desa.berita.detail', [$desa->uri, $berita->slug]) }}"
                            class="text-primary-600 dark:text-primary-400 hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-12 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Map Section -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">Lokasi Desa</h3>
        <div class="bg-gray-300 dark:bg-gray-700 rounded-lg h-96">
            <!-- Placeholder for map iframe -->
            <div class="flex justify-center items-center w-full h-full">
                <p class="text-gray-600 dark:text-gray-400">Peta akan ditampilkan di sini</p>
            </div>
        </div>
    </section>

    <!-- Organization Structure -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">Struktur Organisasi</h3>
        <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg">
            <!-- Placeholder for organization structure -->
            <div class="flex justify-center items-center h-64">
                <p class="text-gray-600 dark:text-gray-400">Struktur organisasi akan ditampilkan di sini</p>
            </div>
        </div>
    </section>

    <!-- Population Stats -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">Jumlah Penduduk</h3>
        <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg text-center">
                <h4 class="mb-2 text-gray-600 dark:text-gray-400 text-lg">Total Penduduk</h4>
                <p class="font-bold text-gray-900 dark:text-white text-3xl">5.328</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg text-center">
                <h4 class="mb-2 text-gray-600 dark:text-gray-400 text-lg">Penduduk Laki-laki</h4>
                <p class="font-bold text-gray-900 dark:text-white text-3xl">2.756</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg text-center">
                <h4 class="mb-2 text-gray-600 dark:text-gray-400 text-lg">Penduduk Perempuan</h4>
                <p class="font-bold text-gray-900 dark:text-white text-3xl">2.572</p>
            </div>
        </div>
    </section>

    <!-- APBDesa -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-gray-900 dark:text-white text-2xl">APBDesa 2025</h3>
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg">
                <h4 class="mb-4 text-gray-900 dark:text-white text-lg">Pendapatan Desa</h4>
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 dark:text-gray-400">Rp 850.000.000</span>
                        <span class="text-gray-600 dark:text-gray-400">85%</span>
                    </div>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2.5">
                        <div class="bg-primary-600 rounded-full h-2.5" style="width: 85%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg">
                <h4 class="mb-4 text-gray-900 dark:text-white text-lg">Belanja Desa</h4>
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600 dark:text-gray-400">Rp 650.000.000</span>
                        <span class="text-gray-600 dark:text-gray-400">65%</span>
                    </div>
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full w-full h-2.5">
                        <div class="bg-primary-600 rounded-full h-2.5" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Highlights -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-gray-900 dark:text-white text-2xl">Highlight Galeri</h3>
            <a href="{{ route('desa.galeri', $desa->uri) }}"
                class="text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua</a>
        </div>

        <div class="gap-4 grid grid-cols-2 md:grid-cols-4">
            <div class="bg-gray-300 dark:bg-gray-700 rounded-lg h-40"></div>
            <div class="bg-gray-300 dark:bg-gray-700 rounded-lg h-40"></div>
            <div class="bg-gray-300 dark:bg-gray-700 rounded-lg h-40"></div>
            <div class="bg-gray-300 dark:bg-gray-700 rounded-lg h-40"></div>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white">
        <div class="mx-auto px-4 py-12 container">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-4">
                <!-- Section 1: Logo & Location -->
                <div>
                    <h4 class="mb-4 font-bold text-xl">{{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }}
                        {{ $desa->nama }}</h4>
                    <p class="mb-2">{{ $desa->alamat }}</p>
                    <div class="flex justify-center items-center bg-gray-700 mt-4 rounded-lg w-24 h-24">
                        <span>Logo</span>
                    </div>
                </div>

                <!-- Section 2: Contact -->
                <div>
                    <h4 class="mb-4 font-bold text-xl">Hubungi Kami</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span>082123456789</span>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-5 h-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span>info@desabangun.id</span>
                        </li>
                    </ul>

                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Section 3: Important Numbers -->
                <div>
                    <h4 class="mb-4 font-bold text-xl">Nomor Telepon Penting</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="tel:112" class="hover:underline">112 - Layanan Darurat</a>
                        </li>
                        <li>
                            <a href="tel:110" class="hover:underline">110 - Polisi</a>
                        </li>
                        <li>
                            <a href="tel:119" class="hover:underline">119 - Ambulans</a>
                        </li>
                        <li>
                            <a href="tel:113" class="hover:underline">113 - Pemadam Kebakaran</a>
                        </li>
                    </ul>
                </div>

                <!-- Section 4: Explore -->
                <div>
                    <h4 class="mb-4 font-bold text-xl">Jelajahi</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="https://www.kemendesa.go.id/" class="hover:underline" target="_blank">Kementerian
                                Desa PDTT</a>
                        </li>
                        <li>
                            <a href="https://www.bps.go.id/" class="hover:underline" target="_blank">Badan Pusat
                                Statistik</a>
                        </li>
                        <li>
                            <a href="https://www.kemendagri.go.id/" class="hover:underline" target="_blank">Kementerian
                                Dalam Negeri</a>
                        </li>
                        <li>
                            <a href="https://www.sultra.go.id/" class="hover:underline" target="_blank">Provinsi Sulawesi
                                Tenggara</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-gray-700 border-t text-center">
                <p>© 2025. Made with ☕ by Jstfire.</p>
            </div>
        </div>
    </footer>

    <!-- Fixed Buttons -->
    <div class="right-6 bottom-6 fixed">
        <button class="bg-primary-600 hover:bg-primary-700 shadow-lg p-3 rounded-full text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    </div>

    <div class="bottom-6 left-6 fixed">
        <a href="{{ route('desa.pengaduan', $desa->uri) }}"
            class="flex justify-center items-center bg-red-600 hover:bg-red-700 shadow-lg p-3 rounded-full text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>
    </div>

    <!-- Toast Notification (Example) -->
    <div id="toast"
        class="hidden bottom-4 left-1/2 fixed bg-green-500 shadow-lg px-6 py-3 rounded-lg text-white -translate-x-1/2 transform">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Berhasil menyimpan data!</span>
        </div>
    </div>

    <script>
        // Toggle dark mode based on user preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Show toast example (for demonstration)
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Uncomment to show toast on page load for demonstration
        // setTimeout(showToast, 1000);
    </script>
    </body>

    </html>
