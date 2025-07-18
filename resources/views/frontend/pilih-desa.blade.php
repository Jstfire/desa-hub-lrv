<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DesaHub</title>
    <meta name="description"
        content="Selamat datang di DesaHub, platform terintegrasi untuk layanan dan informasi desa di Kabupaten Buton Selatan. Pilih desa/kelurahan untuk mengakses layanan.">
    <meta name="keywords" content="desa, kelurahan, layanan publik, berita desa, informasi desa, Buton Selatan">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family={{ $desa->font_family ?? 'Inter' }}:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Application Styles and Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: {{ $desa->color_primary ?? '#10b981' }};
            --secondary-color: {{ $desa->color_secondary ?? '#3b82f6' }};
            --font-family: '{{ $desa->font_family ?? 'Inter' }}', sans-serif;
        }

        body {
            font-family: var(--font-family);
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        .bg-secondary {
            background-color: var(--secondary-color) !important;
        }

        .text-secondary {
            color: var(--secondary-color) !important;
        }

        .border-secondary {
            border-color: var(--secondary-color) !important;
        }

        .hover\:bg-primary:hover {
            background-color: var(--primary-color) !important;
        }

        .hover\:text-primary:hover {
            color: var(--primary-color) !important;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-900 {
                background-color: #1a202c;
            }

            .dark\:text-white {
                color: #ffffff;
            }
        }

        /* Skeleton loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Parallax effect */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">

    <!-- Main Content -->
    <main>
        <div class="bg-gradient-to-br from-green-50 dark:from-gray-900 to-blue-50 dark:to-gray-800 min-h-screen">
            {{-- Header Section --}}
            <section class="py-20">
                <div class="mx-auto px-4 container">
                    <div class="mx-auto max-w-4xl text-center">
                        <div class="mb-8">
                            <h1 class="mb-4 font-bold text-gray-900 dark:text-white text-4xl md:text-6xl">
                                Selamat Datang di
                                <span class="bg-clip-text bg-gradient-to-r from-green-600 to-blue-600 text-transparent">
                                    DesaHub
                                </span>
                            </h1>
                            <p class="mx-auto max-w-2xl text-gray-600 dark:text-gray-300 text-xl">
                                Platform terintegrasi untuk layanan dan informasi desa di Kabupaten Buton Selatan
                            </p>
                        </div>

                        <div class="mb-12">
                            <div
                                class="inline-flex items-center space-x-2 bg-white dark:bg-gray-800 shadow-md px-6 py-3 rounded-full">
                                <x-heroicon-o-map-pin class="w-5 h-5 text-green-600" />
                                <span class="font-medium text-gray-900 dark:text-white">
                                    Pilih desa/kelurahan untuk mengakses layanan
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Desa Selection Section --}}
            <section class="pb-20 min-h-full">
                <div class="mx-auto px-4 container">
                    <div class="mx-auto max-w-6xl">
                        @if ($desas->count() > 0)
                            <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                                @foreach ($desas as $desa)
                                    <a href="/{{ $desa->uri }}"
                                        class="group block bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl p-6 border border-gray-200 dark:border-gray-700 rounded-xl transition-all hover:-translate-y-1 duration-300 transform"
                                        data-spa-ignore>
                                        <div class="flex items-start space-x-4">
                                            <div
                                                class="bg-gradient-to-br from-green-500 to-green-600 shadow-lg p-3 rounded-lg">
                                                @if ($desa->jenis === 'desa')
                                                    <x-heroicon-o-home class="w-8 h-8 text-white" />
                                                @else
                                                    <x-heroicon-o-building-office class="w-8 h-8 text-white" />
                                                @endif
                                            </div>

                                            <div class="flex-1">
                                                <h3
                                                    class="mb-2 font-bold text-gray-900 dark:group-hover:text-green-400 dark:text-white group-hover:text-green-600 text-xl transition-colors">
                                                    {{ $desa->nama_lengkap }}
                                                </h3>
                                                <p class="mb-3 text-gray-600 dark:text-gray-300 text-sm">
                                                    {{ ucfirst($desa->jenis) }}
                                                    @if ($desa->kode_desa)
                                                        • Kode: {{ $desa->kode_desa }}
                                                    @endif
                                                </p>

                                                @if ($desa->deskripsi)
                                                    <p
                                                        class="mb-4 text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                                        {{ Str::limit($desa->deskripsi, 100) }}
                                                    </p>
                                                @endif

                                                <div class="flex justify-between items-center">
                                                    <div
                                                        class="inline-flex items-center space-x-1 text-green-600 dark:text-green-400 text-sm">
                                                        <x-heroicon-o-globe-alt class="w-4 h-4" />
                                                        <span>/{{ $desa->uri }}</span>
                                                    </div>

                                                    <div
                                                        class="inline-flex items-center space-x-1 text-green-600 dark:text-green-400 text-sm transition-transform group-hover:translate-x-1">
                                                        <span>Kunjungi</span>
                                                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white dark:bg-gray-800 shadow-lg p-12 rounded-xl text-center">
                                <div class="mb-6">
                                    <x-heroicon-o-map class="mx-auto w-16 h-16 text-gray-400" />
                                </div>
                                <h3 class="mb-4 font-bold text-gray-900 dark:text-white text-2xl">
                                    Belum Ada Desa Terdaftar
                                </h3>
                                <p class="mx-auto mb-8 max-w-md text-gray-600 dark:text-gray-300">
                                    Saat ini belum ada desa atau kelurahan yang terdaftar dalam sistem DesaHub.
                                </p>
                                <a href="/dashboard"
                                    class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-medium text-white transition-colors">
                                    <x-heroicon-o-plus class="w-5 h-5" />
                                    <span>Tambah Desa</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            {{-- Features Section --}}
            <section class="bg-white dark:bg-gray-800 py-16">
                <div class="mx-auto px-4 container">
                    <div class="mx-auto max-w-6xl">
                        <div class="mb-12 text-center">
                            <h2 class="mb-4 font-bold text-gray-900 dark:text-white text-3xl">
                                Fitur Unggulan DesaHub
                            </h2>
                            <p class="mx-auto max-w-2xl text-gray-600 dark:text-gray-300">
                                Platform terintegrasi yang menyediakan berbagai layanan dan informasi untuk kemudahan
                                masyarakat
                            </p>
                        </div>

                        <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                            <div class="text-center">
                                <div
                                    class="flex justify-center items-center bg-blue-100 dark:bg-blue-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                    <x-heroicon-o-newspaper class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                    Berita Desa
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    Informasi terkini dari desa
                                </p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="flex justify-center items-center bg-green-100 dark:bg-green-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                    <x-heroicon-o-clipboard-document-list
                                        class="w-8 h-8 text-green-600 dark:text-green-400" />
                                </div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                    Layanan Publik
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    Akses mudah ke layanan desa
                                </p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="flex justify-center items-center bg-purple-100 dark:bg-purple-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                    <x-heroicon-o-document-text class="w-8 h-8 text-purple-600 dark:text-purple-400" />
                                </div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                    Publikasi
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    Dokumen dan laporan resmi
                                </p>
                            </div>

                            <div class="text-center">
                                <div
                                    class="flex justify-center items-center bg-orange-100 dark:bg-orange-900 mx-auto mb-4 p-3 rounded-lg w-16 h-16">
                                    <x-heroicon-o-chat-bubble-left-ellipsis
                                        class="w-8 h-8 text-orange-600 dark:text-orange-400" />
                                </div>
                                <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
                                    Pengaduan
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">
                                    Sampaikan aspirasi Anda
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 mt-16 text-white">
        <div class="mx-auto px-4 py-12 container">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-4">
                <!-- Logo & Info -->
                <div class="md:col-span-1">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logo_busel.png') }}" alt="DesaHub Logo" class="mr-4 w-16 h-16">
                        <div>
                            <h3 class="font-bold text-xl">DesaHub</h3>
                            <p class="text-gray-400">Kabupaten Buton Selatan</p>
                        </div>
                    </div>
                    <div class="flex items-start mb-2">
                        <i class="mt-1 mr-2 w-3 text-primary fas fa-map-marker-alt"></i>
                        <span class="text-gray-400">Kantor Bupati Kabupaten Buton Selatan, Laompo, Batauga, Kabupaten
                            Buton, Sulawesi Tenggara 93752</span>
                    </div>
                </div>

                <!-- Hubungi Kami -->
                <div class="md:col-span-1">
                    <h4 class="mb-4 font-semibold text-lg">Hubungi Kami</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <i class="mr-2 text-primary fas fa-phone"></i>
                            <span class="text-gray-400">0123-456-789</span>
                        </div>
                        <div class="flex items-center">
                            <i class="mr-2 text-primary fas fa-envelope"></i>
                            <span class="text-gray-400">xxx@gmail.com</span>
                        </div>
                        <div class="flex items-center space-x-3 mt-4">
                            <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tautan Penting -->
                <div class="md:col-span-1">
                    <h4 class="mb-4 font-semibold text-lg">Tautan Penting</h4>
                    <div class="space-y-2">
                        <a href="#" class="block text-gray-400 hover:text-primary transition-colors">Polsek
                            Terdekat</a>
                        <a href="#"
                            class="block text-gray-400 hover:text-primary transition-colors">Puskesmas</a>
                        <a href="#" class="block text-gray-400 hover:text-primary transition-colors">Dinsos</a>
                        <a href="#" class="block text-gray-400 hover:text-primary transition-colors">Damkar</a>
                    </div>
                </div>

                <!-- Jelajahi -->
                <div class="md:col-span-1">
                    <h4 class="mb-4 font-semibold text-lg">Jelajahi</h4>
                    <div class="space-y-2">
                        <a href="{{ route('desa.beranda', $desa->uri) }}"
                            class="block text-gray-400 hover:text-primary transition-colors">Beranda</a>
                        <a href="{{ route('desa.berita', $desa->uri) }}"
                            class="block text-gray-400 hover:text-primary transition-colors">Berita</a>
                        <a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                            class="block text-gray-400 hover:text-primary transition-colors">Layanan Publik</a>
                        <a href="{{ route('desa.profil', $desa->uri) }}"
                            class="block text-gray-400 hover:text-primary transition-colors">Profil</a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-gray-700 border-t text-center">
                <p class="text-gray-400">&copy; 2025. Made with ☕ by Jstfire.
                </p>
            </div>
        </div>
    </footer>

    <!-- Visitor Stats Modal -->
    <div id="visitorStatsModal" class="hidden z-50 fixed inset-0 bg-black bg-opacity-50">
        <div class="flex justify-center items-center p-4 min-h-screen">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800 dark:text-white text-lg">Statistik Pengunjung</h3>
                    <button id="closeVisitorStatsModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="visitorStatsContent" class="space-y-3">
                    <!-- Stats will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="hidden top-4 right-4 z-50 fixed">
        <div class="bg-green-500 shadow-lg px-6 py-3 rounded-lg text-white">
            <div class="flex items-center">
                <i class="mr-2 fas fa-check-circle"></i>
                <span id="toastMessage"></span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeToggleMobile = document.getElementById('darkModeToggleMobile');
        const html = document.documentElement;

        function toggleDarkMode() {
            html.classList.toggle('dark');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }

        darkModeToggle?.addEventListener('click', toggleDarkMode);
        darkModeToggleMobile?.addEventListener('click', toggleDarkMode);

        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuButton?.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Visitor Stats Modal
        const visitorStatsButton = document.getElementById('visitorStatsButton');
        const visitorStatsModal = document.getElementById('visitorStatsModal');
        const closeVisitorStatsModal = document.getElementById('closeVisitorStatsModal');
        const visitorStatsContent = document.getElementById('visitorStatsContent');

        visitorStatsButton?.addEventListener('click', async () => {
            visitorStatsModal.classList.remove('hidden');

            try {
                const response = await fetch('{{ route('desa.visitor.stats', $desa->uri) }}');
                const data = await response.json();

                visitorStatsContent.innerHTML = `
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Hari Ini:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.hari_ini}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Kemarin:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.kemarin}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Minggu Ini:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.minggu_ini}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Minggu Lalu:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.minggu_lalu}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Bulan Ini:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.bulan_ini}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Bulan Lalu:</span>
                        <span class="font-semibold text-gray-800 dark:text-white">${data.bulan_lalu}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t">
                        <span class="font-semibold text-gray-600 dark:text-gray-400">Total:</span>
                        <span class="font-bold text-primary">${data.total}</span>
                    </div>
                `;
            } catch (error) {
                visitorStatsContent.innerHTML = '<p class="text-red-500">Error loading statistics</p>';
            }
        });

        closeVisitorStatsModal?.addEventListener('click', () => {
            visitorStatsModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        visitorStatsModal?.addEventListener('click', (e) => {
            if (e.target === visitorStatsModal) {
                visitorStatsModal.classList.add('hidden');
            }
        });

        // Check for Laravel flash messages
        @if (session('success'))
            window.addEventListener('DOMContentLoaded', () => {
                notify('{{ session('success') }}', 'success');
            });
        @endif

        @if (session('error'))
            window.addEventListener('DOMContentLoaded', () => {
                notify('{{ session('error') }}', 'error');
            });
        @endif

        @if (session('warning'))
            window.addEventListener('DOMContentLoaded', () => {
                notify('{{ session('warning') }}', 'warning');
            });
        @endif
    </script>

    <!-- Toast Component -->
    <x-toast />
    @stack('scripts')
</body>

</html>
