@extends('frontend.desa.layouts.main')

@section('title', $desa->nama_lengkap)

@section('content')
    <!-- Hero Section with Gradient Background -->
    <section class="relative bg-gradient-to-br from-primary/10 via-background to-secondary/10 py-20 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.02] dark:bg-grid-white/[0.01]"></div>
        <div class="relative mx-auto px-4 container">
            <div class="mx-auto max-w-4xl text-center">
                <h1 class="mb-6 font-bold text-foreground text-4xl md:text-5xl lg:text-6xl animate-fade-in">
                    Selamat Datang di <span class="text-primary">{{ $desa->nama_lengkap }}</span>
                </h1>
                <p class="mx-auto mb-8 max-w-2xl text-muted-foreground text-lg md:text-xl animate-fade-in-delay">
                    {{ $desa->deskripsi ?? 'Website resmi yang menyediakan informasi terkait pemerintahan desa, kegiatan, layanan publik, dan data statistik untuk masyarakat.' }}
                </p>
                <div class="flex flex-wrap justify-center gap-4 animate-fade-in-delay-2">
                    <a href="{{ route('desa.layanan-publik', $desa->uri) }}" 
                       class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 px-6 py-3 rounded-lg font-medium text-primary-foreground transition-all hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Layanan Publik
                    </a>
                    <a href="{{ route('desa.pengaduan', $desa->uri) }}" 
                       class="inline-flex items-center gap-2 bg-background hover:bg-accent px-6 py-3 border border-border hover:border-primary rounded-lg font-medium text-foreground transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Sampaikan Aspirasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats Section -->
    <section class="py-12">
        <div class="mx-auto px-4 container">
            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Penduduk -->
                <div class="group relative bg-card hover:bg-accent border border-border hover:border-primary p-6 rounded-xl transition-all duration-300 hover:shadow-lg overflow-hidden">
                    <div class="absolute -right-4 -top-4 bg-primary/10 rounded-full w-24 h-24 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-primary/10 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-medium text-muted-foreground">Total Penduduk</h3>
                        </div>
                        <p class="font-bold text-foreground text-3xl">5.328</p>
                        <p class="text-muted-foreground text-sm">Jiwa</p>
                    </div>
                </div>

                <!-- Laki-laki -->
                <div class="group relative bg-card hover:bg-accent border border-border hover:border-blue-500 p-6 rounded-xl transition-all duration-300 hover:shadow-lg overflow-hidden">
                    <div class="absolute -right-4 -top-4 bg-blue-500/10 rounded-full w-24 h-24 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-blue-500/10 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="font-medium text-muted-foreground">Laki-laki</h3>
                        </div>
                        <p class="font-bold text-foreground text-3xl">2.756</p>
                        <p class="text-muted-foreground text-sm">51.7%</p>
                    </div>
                </div>

                <!-- Perempuan -->
                <div class="group relative bg-card hover:bg-accent border border-border hover:border-pink-500 p-6 rounded-xl transition-all duration-300 hover:shadow-lg overflow-hidden">
                    <div class="absolute -right-4 -top-4 bg-pink-500/10 rounded-full w-24 h-24 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-pink-500/10 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="font-medium text-muted-foreground">Perempuan</h3>
                        </div>
                        <p class="font-bold text-foreground text-3xl">2.572</p>
                        <p class="text-muted-foreground text-sm">48.3%</p>
                    </div>
                </div>

                <!-- Kepala Keluarga -->
                <div class="group relative bg-card hover:bg-accent border border-border hover:border-amber-500 p-6 rounded-xl transition-all duration-300 hover:shadow-lg overflow-hidden">
                    <div class="absolute -right-4 -top-4 bg-amber-500/10 rounded-full w-24 h-24 transition-transform group-hover:scale-110"></div>
                    <div class="relative">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-amber-500/10 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <h3 class="font-medium text-muted-foreground">Kepala Keluarga</h3>
                        </div>
                        <p class="font-bold text-foreground text-3xl">1.426</p>
                        <p class="text-muted-foreground text-sm">KK</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-16 bg-muted/30">
        <div class="mx-auto px-4 container">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="mb-2 font-bold text-foreground text-3xl">Berita Terbaru</h2>
                    <p class="text-muted-foreground">Informasi dan kegiatan terkini dari {{ $desa->nama_lengkap }}</p>
                </div>
                <a href="{{ route('desa.berita', $desa->uri) }}" 
                   class="hidden md:inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7-7"></path>
                    </svg>
                </a>
            </div>

            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @forelse($beritaTerbaru as $berita)
                    <x-frontend.desa.components.berita-card :item="$berita" :desa="$desa" view="grid" />
                @empty
                    <div class="col-span-3 py-12 text-center">
                        <div class="mx-auto mb-4 bg-muted rounded-full w-20 h-20 flex items-center justify-center">
                            <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                        <p class="text-muted-foreground mb-4">Belum ada berita yang dipublikasikan.</p>
                        <a href="{{ route('desa.berita', $desa->uri) }}" 
                           class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium">
                            Kembali ke halaman berita
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 text-center md:hidden">
                <a href="{{ route('desa.berita', $desa->uri) }}" 
                   class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium">
                    Lihat Semua Berita
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-foreground text-2xl">Lokasi Desa</h3>
        <div class="bg-muted border border-border rounded-lg h-96">
            <!-- Placeholder for map iframe -->
            <div class="flex justify-center items-center w-full h-full">
                <p class="text-muted-foreground">Peta akan ditampilkan di sini</p>
            </div>
        </div>
    </section>

    <!-- Organization Structure -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-foreground text-2xl">Struktur Organisasi</h3>
        <div class="bg-card shadow-sm p-6 border border-border rounded-lg">
            <!-- Placeholder for organization structure -->
            <div class="flex justify-center items-center h-64">
                <p class="text-muted-foreground">Struktur organisasi akan ditampilkan di sini</p>
            </div>
        </div>
    </section>

    <!-- Population Stats -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-foreground text-2xl">Jumlah Penduduk</h3>
        <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
            <div
                class="bg-card shadow-sm hover:shadow-md p-6 border border-border rounded-lg text-center transition-shadow">
                <h4 class="mb-2 text-muted-foreground text-lg">Total Penduduk</h4>
                <p class="font-bold text-card-foreground text-3xl">5.328</p>
            </div>
            <div
                class="bg-card shadow-sm hover:shadow-md p-6 border border-border rounded-lg text-center transition-shadow">
                <h4 class="mb-2 text-muted-foreground text-lg">Penduduk Laki-laki</h4>
                <p class="font-bold text-card-foreground text-3xl">2.756</p>
            </div>
            <div
                class="bg-card shadow-sm hover:shadow-md p-6 border border-border rounded-lg text-center transition-shadow">
                <h4 class="mb-2 text-muted-foreground text-lg">Penduduk Perempuan</h4>
                <p class="font-bold text-card-foreground text-3xl">2.572</p>
            </div>
        </div>
    </section>

    <!-- APBDesa -->
    <section class="mb-12">
        <h3 class="mb-6 font-bold text-foreground text-2xl">APBDesa 2025</h3>
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
            <div class="bg-card shadow-sm hover:shadow-md p-6 border border-border rounded-lg transition-shadow">
                <h4 class="mb-4 font-semibold text-card-foreground text-lg">Pendapatan Desa</h4>
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-muted-foreground">Rp 850.000.000</span>
                        <span class="text-muted-foreground">85%</span>
                    </div>
                    <div class="bg-secondary rounded-full w-full h-2.5">
                        <div class="bg-primary rounded-full h-2.5 transition-all duration-300" style="width: 85%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-card shadow-sm hover:shadow-md p-6 border border-border rounded-lg transition-shadow">
                <h4 class="mb-4 font-semibold text-card-foreground text-lg">Belanja Desa</h4>
                <div class="mb-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-muted-foreground">Rp 650.000.000</span>
                        <span class="text-muted-foreground">65%</span>
                    </div>
                    <div class="bg-secondary rounded-full w-full h-2.5">
                        <div class="bg-primary rounded-full h-2.5 transition-all duration-300" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Highlights -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-foreground text-2xl">Highlight Galeri</h3>
            <a href="{{ route('desa.galeri', $desa->uri) }}"
                class="text-primary hover:text-primary/80 transition-colors">Lihat Semua</a>
        </div>

        <div class="gap-4 grid grid-cols-2 md:grid-cols-4">
            <div class="bg-muted hover:shadow-md border border-border rounded-lg h-40 transition-shadow"></div>
            <div class="bg-muted hover:shadow-md border border-border rounded-lg h-40 transition-shadow"></div>
            <div class="bg-muted hover:shadow-md border border-border rounded-lg h-40 transition-shadow"></div>
            <div class="bg-muted hover:shadow-md border border-border rounded-lg h-40 transition-shadow"></div>
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
                        {{ $desa->nama_lengkap }}</h4>
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
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
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
        <button
            class="inline-flex justify-center items-center bg-primary hover:bg-primary/90 disabled:opacity-50 shadow-lg rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-12 h-12 font-medium text-primary-foreground text-sm whitespace-nowrap transition-colors disabled:pointer-events-none">
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
            class="inline-flex justify-center items-center bg-destructive hover:bg-destructive/90 disabled:opacity-50 shadow-lg rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-12 h-12 font-medium text-destructive-foreground text-sm whitespace-nowrap transition-colors disabled:pointer-events-none">
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
