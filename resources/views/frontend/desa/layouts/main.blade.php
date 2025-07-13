<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: $persist(false) }" :class="{ 'dark': darkMode }" x-init="
    if (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('_x_darkMode')) {
        darkMode = true;
    }
">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lato:wght@300;400;700&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- TailwindCSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-family: {{ $desa->font_family ?? 'Inter' }}, system-ui, sans-serif;
            --color-primary: {{ $desa->color_primary ?? '#3b82f6' }};
            --color-secondary: {{ $desa->color_secondary ?? '#64748b' }};
            --primary-color-hsl: {{ \App\Helpers\ColorHelper::hexToHsl($desa->color_primary ?? '#3b82f6') }};
            --secondary-color-hsl: {{ \App\Helpers\ColorHelper::hexToHsl($desa->color_secondary ?? '#64748b') }};
        }

        body {
            font-family: var(--font-family);
        }

        /* Loading skeleton animations */
        .skeleton {
            @apply bg-gray-200 dark:bg-gray-700 animate-pulse;
        }

        .skeleton-text {
            @apply bg-gray-200 dark:bg-gray-700 rounded h-4 animate-pulse;
        }

        .skeleton-title {
            @apply bg-gray-200 dark:bg-gray-700 rounded h-6 animate-pulse;
        }

        .skeleton-image {
            @apply bg-gray-200 dark:bg-gray-700 rounded animate-pulse;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>

    @yield('head')
</head>

<body class="bg-background text-foreground">
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden z-50 fixed inset-0 bg-white dark:bg-gray-900">
        <div class="flex justify-center items-center h-full">
            <div class="text-center">
                <div
                    class="mx-auto mb-4 border-4 border-t-blue-600 border-blue-200 rounded-full w-12 h-12 animate-spin">
                </div>
                <p class="text-gray-600 dark:text-gray-400">Memuat halaman...</p>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div data-toast-container class="top-4 right-4 z-50 fixed space-y-4"></div>

    <!-- Header Section -->
    <header class="bg-card border-b border-border shadow-sm">
        <div class="mx-auto px-4 py-6 container">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="font-bold text-card-foreground text-2xl">
                        {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
                    </h1>
                    <p class="text-muted-foreground text-sm">
                        {{ $desa->alamat ?? 'Kecamatan ' . $desa->kecamatan . ', ' . $desa->kabupaten }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode"
                        class="text-muted-foreground hover:text-foreground transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>

                    <!-- Logo -->
                    @if ($desa->getFirstMediaUrl('logo'))
                        <img src="{{ $desa->getFirstMediaUrl('logo') }}" alt="Logo {{ $desa->nama }}"
                            class="rounded-full w-16 h-16 object-cover">
                    @else
                        <div
                            class="flex justify-center items-center bg-gray-200 dark:bg-gray-700 rounded-full w-16 h-16">
                            <span class="font-bold text-xl">Logo</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="bg-primary text-primary-foreground">
            <div class="mx-auto px-4 container">
                <div class="flex justify-between items-center h-16">
                    <div class="hidden md:flex items-center space-x-4 overflow-x-auto">
                        <a href="{{ route('desa.index', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Beranda</a>
                        <a href="{{ route('desa.publikasi', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Publikasi</a>
                        <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Data
                            Sektoral</a>

                        <!-- Informasi Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors flex items-center">
                                Informasi
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 rounded-md shadow-lg bg-popover border border-border focus:outline-none">
                                <div class="py-1">
                                    <a href="{{ route('desa.profil', $desa->uri) }}" class="block px-4 py-2 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">Profil Desa</a>
                                    <a href="{{ route('desa.layanan-publik', $desa->uri) }}" class="block px-4 py-2 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">Layanan Publik</a>
                                    <a href="{{ route('desa.ppid', $desa->uri) }}" class="block px-4 py-2 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">PPID</a>
                                    <a href="{{ route('desa.berita', $desa->uri) }}" class="block px-4 py-2 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">Berita</a>
                                    <a href="{{ route('desa.metadata', $desa->uri) }}" class="block px-4 py-2 text-sm text-popover-foreground hover:bg-accent hover:text-accent-foreground">Metadata</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('desa.galeri', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Galeri</a>
                        <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Pengaduan</a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button data-mobile-menu-toggle class="text-primary-foreground hover:text-primary-foreground/80 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation -->
                <div data-mobile-menu class="hidden md:hidden pb-4">
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('desa.index', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Beranda</a>
                        <a href="{{ route('desa.publikasi', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Publikasi</a>
                        <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Data
                            Sektoral</a>

                        <!-- Informasi Dropdown for Mobile -->
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors w-full text-left flex items-center justify-between">
                                Informasi
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" class="pl-4 pt-2 space-y-2">
                                <a href="{{ route('desa.profil', $desa->uri) }}" class="block px-3 py-2 text-sm text-primary-foreground hover:bg-primary/80 rounded-md">Profil Desa</a>
                                <a href="{{ route('desa.layanan-publik', $desa->uri) }}" class="block px-3 py-2 text-sm text-primary-foreground hover:bg-primary/80 rounded-md">Layanan Publik</a>
                                <a href="{{ route('desa.ppid', $desa->uri) }}" class="block px-3 py-2 text-sm text-primary-foreground hover:bg-primary/80 rounded-md">PPID</a>
                                <a href="{{ route('desa.berita', $desa->uri) }}" class="block px-3 py-2 text-sm text-primary-foreground hover:bg-primary/80 rounded-md">Berita</a>
                                <a href="{{ route('desa.metadata', $desa->uri) }}" class="block px-3 py-2 text-sm text-primary-foreground hover:bg-primary/80 rounded-md">Metadata</a>
                            </div>
                        </div>

                        <a href="{{ route('desa.galeri', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Galeri</a>
                        <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                            class="hover:bg-primary/90 px-3 py-2 rounded-md text-primary-foreground transition-colors">Pengaduan</a>
                    </div>
                </div>
            </div>
            class="hover:bg-primary-700 px-3 py-2 rounded-md text-white">Publikasi</a>
            <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                class="hover:bg-primary-700 px-3 py-2 rounded-md text-white">Data Sektoral</a>
            <a href="{{ route('desa.metadata', $desa->uri) }}"
                class="hover:bg-primary-700 px-3 py-2 rounded-md text-white">Metadata</a>
            <a href="{{ route('desa.ppid', $desa->uri) }}"
                class="hover:bg-primary-700 px-3 py-2 rounded-md text-white">PPID</a>
            <a href="{{ route('desa.galeri', $desa->uri) }}"
                class="hover:bg-primary-700 px-3 py-2 rounded-md text-white">Galeri</a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-primary-700 dark:bg-gray-800">
                <div class="space-y-1 px-2 pt-2 pb-3">
                    <a href="{{ route('desa.index', $desa->uri) }}"
                        class="block hover:bg-primary-800 px-3 py-2 rounded-md text-white">Beranda</a>
                    <a href="{{ route('desa.publikasi', $desa->uri) }}"
                        class="block hover:bg-primary-800 px-3 py-2 rounded-md text-white">Publikasi</a>
                    <a href="{{ route('desa.data-sektoral', $desa->uri) }}"
                        class="block hover:bg-primary-800 px-3 py-2 rounded-md text-white">Data Sektoral</a>

                    <!-- Informasi Dropdown for Mobile (third section) -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="hover:bg-primary-800 px-3 py-2 rounded-md text-white w-full text-left flex items-center justify-between">
                            Informasi
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="pl-4 pt-2 space-y-2">
                            <a href="{{ route('desa.profil', $desa->uri) }}" class="block px-3 py-2 text-sm text-white hover:bg-primary-800 rounded-md">Profil Desa</a>
                            <a href="{{ route('desa.layanan-publik', $desa->uri) }}" class="block px-3 py-2 text-sm text-white hover:bg-primary-800 rounded-md">Layanan Publik</a>
                            <a href="{{ route('desa.ppid', $desa->uri) }}" class="block px-3 py-2 text-sm text-white hover:bg-primary-800 rounded-md">PPID</a>
                            <a href="{{ route('desa.berita', $desa->uri) }}" class="block px-3 py-2 text-sm text-white hover:bg-primary-800 rounded-md">Berita</a>
                            <a href="{{ route('desa.metadata', $desa->uri) }}" class="block px-3 py-2 text-sm text-white hover:bg-primary-800 rounded-md">Metadata</a>
                        </div>
                    </div>

                    <a href="{{ route('desa.galeri', $desa->uri) }}"
                        class="block hover:bg-primary-800 px-3 py-2 rounded-md text-white">Galeri</a>
                    <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                        class="block hover:bg-primary-800 px-3 py-2 rounded-md text-white">Pengaduan</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content with SPA Support -->
    <main data-spa-content>
        <!-- Skeleton Loading -->
        <div data-skeleton class="hidden">
            <div class="mx-auto px-4 py-8 container">
                <div class="space-y-4">
                    <div class="mb-4 w-1/3 skeleton-title"></div>
                    <div class="mb-2 w-2/3 skeleton-text"></div>
                    <div class="mb-4 w-1/2 skeleton-text"></div>
                    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="bg-white dark:bg-gray-800 shadow-md p-6 rounded-lg">
                                <div class="mb-4 w-full h-32 skeleton-image"></div>
                                <div class="mb-2 w-3/4 skeleton-title"></div>
                                <div class="mb-1 w-full skeleton-text"></div>
                                <div class="w-2/3 skeleton-text"></div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Actual Content -->
        <div data-content data-aos="fade-up">
            @yield('content')
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-secondary text-secondary-foreground py-12">
        <div class="mx-auto px-4 container">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <h4 class="mb-4 font-semibold text-lg">Tentang Kami</h4>
                    <p class="mb-4 text-secondary-foreground/80">
                        {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }} merupakan bagian dari
                        pemerintahan di {{ $desa->kecamatan }}, {{ $desa->kabupaten }}, {{ $desa->provinsi }}.
                    </p>
                </div>

                <div>
                    <h4 class="mb-4 font-semibold text-lg">Kontak</h4>
                    <p class="text-secondary-foreground/80">Alamat: {{ $desa->alamat ?? '-' }}</p>
                    <p class="text-secondary-foreground/80">Email: {{ $desa->email ?? '-' }}</p>
                    <p class="text-secondary-foreground/80">Telepon: {{ $desa->telepon ?? '-' }}</p>
                </div>

                <div>
                    <h4 class="mb-4 font-semibold text-lg">Tautan Penting</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('desa.berita', $desa->uri) }}"
                                class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">Berita</a></li>
                        <li><a href="{{ route('desa.layanan-publik', $desa->uri) }}"
                                class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">Layanan Publik</a></li>
                        <li><a href="{{ route('desa.publikasi', $desa->uri) }}"
                                class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">Publikasi</a></li>
                        <li><a href="{{ route('desa.pengaduan', $desa->uri) }}"
                                class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">Pengaduan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 font-semibold text-lg">Media Sosial</h4>
                    <div class="flex space-x-4">
                        @if ($desa->facebook)
                            <a href="{{ $desa->facebook }}" target="_blank" class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        @if ($desa->twitter)
                            <a href="{{ $desa->twitter }}" target="_blank" class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        @endif

                        @if ($desa->instagram)
                            <a href="{{ $desa->instagram }}" target="_blank" class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        @if ($desa->youtube)
                            <a href="{{ $desa->youtube }}" target="_blank" class="text-secondary-foreground/80 hover:text-secondary-foreground transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-border border-t text-secondary-foreground/80 text-center">
                <p>© {{ date('Y') }} {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}. Hak
                    Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Fixed Buttons -->
    <div class="right-4 bottom-4 z-50 fixed space-y-3">
        <!-- Visitor Stats Button -->
        <div class="relative">
            <button data-visitor-stats
                class="bg-primary hover:bg-primary/90 shadow-lg p-3 rounded-full text-primary-foreground transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </button>

            <!-- Visitor Stats Modal -->
            <div data-visitor-stats-modal
                class="hidden right-0 bottom-full absolute bg-popover shadow-lg mb-2 p-4 rounded-lg w-80 border border-border">
                <h3 class="mb-4 font-semibold text-popover-foreground">Statistik Pengunjung</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-primary/10 rounded-lg border border-border">
                            <div class="text-lg font-bold text-primary" id="stats-today">-</div>
                            <div class="text-xs text-muted-foreground">Hari Ini</div>
                        </div>
                        <div class="text-center p-3 bg-secondary/10 rounded-lg border border-border">
                            <div class="text-lg font-bold text-secondary" id="stats-yesterday">-</div>
                            <div class="text-xs text-muted-foreground">Kemarin</div>
                        </div>
                        <div class="text-center p-3 bg-accent/10 rounded-lg border border-border">
                            <div class="text-lg font-bold text-accent-foreground" id="stats-week">-</div>
                            <div class="text-xs text-muted-foreground">Minggu Ini</div>
                        </div>
                        <div class="text-center p-3 bg-muted/50 rounded-lg border border-border">
                            <div class="text-lg font-bold text-foreground" id="stats-month">-</div>
                            <div class="text-xs text-muted-foreground">Bulan Ini</div>
                        </div>
                    </div>
                    <div class="text-center p-3 bg-muted rounded-lg border border-border">
                        <div class="text-xl font-bold text-foreground" id="stats-total">-</div>
                        <div class="text-xs text-muted-foreground">Total Pengunjung</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Toggle Button -->
        <button data-theme-toggle
            class="bg-muted hover:bg-muted/80 shadow-lg p-3 rounded-full text-muted-foreground hover:text-foreground transition-colors">
            <svg class="hidden dark:block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <svg class="dark:hidden block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>

    <!-- Fixed Button: Pengaduan (bottom left) -->
    <div class="bottom-4 left-4 z-50 fixed">
        <a href="{{ route('desa.pengaduan', $desa->uri) }}"
            class="flex justify-center items-center bg-destructive hover:bg-destructive/90 shadow-lg p-3 rounded-full text-destructive-foreground transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                </path>
            </svg>
        </a>
    </div>

    <!-- Toast Notifications -->
    @if (session('success') || session('error'))
        <div
            class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 {{ session('error') ? 'bg-destructive border-destructive text-destructive-foreground' : 'bg-primary border-primary text-primary-foreground' }} p-4 rounded-lg shadow-lg max-w-xs border">
            <div class="flex items-center">
                @if (session('success'))
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                @else
                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                @endif
            </div>
        </div>
    @endif

    @yield('scripts')
</body>

</html>
