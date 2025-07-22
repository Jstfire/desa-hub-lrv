<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $desa->nama_lengkap) - {{ $desa->nama_lengkap }}</title>
    <meta name="description" content="@yield('description', 'Situs resmi ' . $desa->nama_lengkap)">
    <meta name="keywords" content="@yield('keywords', 'desa, kelurahan, ' . $desa->nama_lengkap . ', pemerintahan')">

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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom-swiper.css') }}">
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">
    <!-- Navigation -->
    <nav class="top-0 z-50 sticky bg-white dark:bg-gray-800 shadow-lg">
        <div class="mx-auto px-4 py-3 container">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('desa.beranda', $desa->uri) }}" class="flex items-center">
                        <img src="{{ asset('images/logo_busel.png') }}" alt="Logo" class="mr-3 w-14">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-base">{{ ucfirst($desa->jenis) }}</p>
                            <h1 class="font-bold text-gray-800 dark:text-white text-2xl">{{ $desa->nama }}</h1>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('desa.beranda', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Beranda</a>
                    <a href="{{ route('desa.berita', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Berita</a>
                    <a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Layanan Publik</a>

                    <!-- Dropdown for more pages -->
                    <div class="group relative">
                        <button
                            class="flex items-center text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">
                            Informasi
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div
                            class="invisible group-hover:visible left-0 z-50 absolute bg-white dark:bg-gray-800 opacity-0 group-hover:opacity-100 shadow-lg mt-2 rounded-md w-48 transition-all duration-200">
                            <a href="{{ route('desa.profil', $desa->uri) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Profil</a>
                            <a href="{{ route('desa.publikasi', $desa->uri) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Publikasi</a>
                            <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Data
                                Sektoral</a>
                            <a href="{{ route('desa.metadata', $desa->uri) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Metadata</a>
                            <a href="{{ route('desa.ppid', $desa->uri) }}"
                                class="block hover:bg-gray-100 dark:hover:bg-gray-700 px-4 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">PPID</a>
                        </div>
                    </div>

                    <a href="{{ route('desa.galeri', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Galeri</a>
                    <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Pengaduan</a>

                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">
                        <i class="dark:hidden fas fa-moon"></i>
                        <i class="hidden dark:inline fas fa-sun"></i>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobileMenuButton"
                        class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden">
                <div class="space-y-1 px-2 sm:px-3 pt-2 pb-3">
                    <a href="{{ route('desa.beranda', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Beranda</a>
                    <a href="{{ route('desa.berita', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Berita</a>
                    <a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Layanan
                        Publik</a>
                    <a href="{{ route('desa.profil', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Profil</a>
                    <a href="{{ route('desa.publikasi', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Publikasi</a>
                    <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Data
                        Sektoral</a>
                    <a href="{{ route('desa.metadata', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Metadata</a>
                    <a href="{{ route('desa.ppid', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">PPID</a>
                    <a href="{{ route('desa.galeri', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Galeri</a>
                    <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                        class="block px-3 py-2 text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">Pengaduan</a>
                    <div class="px-3 py-2">
                        <button id="darkModeToggleMobile"
                            class="text-gray-700 hover:text-primary dark:text-gray-300 transition-colors">
                            <i class="dark:hidden mr-2 fas fa-moon"></i>
                            <i class="hidden dark:inline mr-2 fas fa-sun"></i>
                            <span class="dark:hidden">Mode Gelap</span>
                            <span class="hidden dark:inline">Mode Terang</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 mt-16 text-white">
        <div class="mx-auto px-4 py-12 container">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-4">
                @if (isset($footerSections['section1']))
                    <div class="md:col-span-1">
                        <h4 class="mb-4 font-semibold text-lg">{{ $footerSections['section1']->judul }}</h4>
                        <div class="flex items-center mb-4">
                            @if (isset($footerSections['section1']) && $footerSections['section1']->hasMedia('logo_desa'))
                                <img src="{{ $footerSections['section1']->getFirstMediaUrl('logo_desa') }}"
                                    alt="Logo Desa" class="mr-3 w-auto h-10">
                            @else
                                <img src="{{ asset('images/logo_busel.png') }}" alt="Logo Kabupaten Buton Selatan"
                                    class="mr-3 w-auto h-10">
                            @endif
                            <div>
                                <h3 class="font-bold text-xl">{{ $desa->nama_lengkap }}</h3>
                                <p class="text-gray-400">{{ ucfirst($desa->jenis) }}</p>
                            </div>
                        </div>
                        @if (isset($footerSections['section1']->konten['alamat']))
                            <div class="flex items-start mb-2">
                                <i class="mt-1 mr-2 text-primary fas fa-map-marker-alt"></i>
                                <span class="text-gray-400">{{ $footerSections['section1']->konten['alamat'] }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                @if (isset($footerSections['section2']))
                    <div class="md:col-span-1">
                        <h4 class="mb-4 font-semibold text-lg">{{ $footerSections['section2']->judul }}</h4>
                        <div class="space-y-2">
                            @if (isset($footerSections['section2']->konten['kontak']))
                                @foreach ($footerSections['section2']->konten['kontak'] as $kontak)
                                    @if ($kontak['aktif'])
                                        <div class="flex items-center">
                                            <i
                                                class="mr-2 text-primary fas fa-{{ $kontak['tipe'] === 'telepon' ? 'phone' : 'envelope' }}"></i>
                                            <span class="text-gray-400">{{ $kontak['nilai'] }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if (isset($footerSections['section2']->konten['sosmed']))
                                <div class="flex items-center space-x-3 mt-4">
                                    @foreach ($footerSections['section2']->konten['sosmed'] as $sosmed)
                                        @if ($sosmed['aktif'])
                                            <a href="{{ $sosmed['url'] }}" target="_blank"
                                                class="text-gray-400 hover:text-primary transition-colors">
                                                <i class="fab fa-{{ $sosmed['tipe'] }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if (isset($footerSections['section3']))
                    <div class="md:col-span-1">
                        <h4 class="mb-4 font-semibold text-lg">{{ $footerSections['section3']->judul }}</h4>
                        @if (isset($footerSections['section3']->konten['nomor_penting']))
                            <div class="space-y-2">
                                @foreach ($footerSections['section3']->konten['nomor_penting'] as $nomor)
                                    @if ($nomor['aktif'])
                                        <p class="text-gray-400">{{ $nomor['nama'] }}: {{ $nomor['nomor'] }}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if (isset($footerSections['section4']))
                    <div class="md:col-span-1">
                        <h4 class="mb-4 font-semibold text-lg">{{ $footerSections['section4']->judul }}</h4>
                        @if (isset($footerSections['section4']->konten['link_penting']))
                            <div class="space-y-2">
                                @foreach ($footerSections['section4']->konten['link_penting'] as $link)
                                    @if ($link['aktif'])
                                        <a href="{{ $link['url'] }}" target="_blank"
                                            class="block text-gray-400 hover:text-primary transition-colors">{{ $link['nama'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @if (isset($footerSections['copyright']) && isset($footerSections['copyright']->konten['text']))
                <div class="mt-8 pt-8 border-gray-700 border-t text-center">
                    <p class="text-gray-400">{!! $footerSections['copyright']->konten['text'] !!}</p>
                </div>
            @endif
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

    <!-- Fixed Buttons for Visitor Stats & Pengaduan -->
    @if (isset($desa))
        <x-fixed-buttons :desa="$desa" />
    @endif

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
