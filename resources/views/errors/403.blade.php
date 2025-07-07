<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - 403</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="flex flex-col justify-center items-center px-4 min-h-screen">
        <div class="text-center">
            <!-- Logo/Icon -->
            <div class="mb-8">
                <div
                    class="flex justify-center items-center bg-yellow-100 dark:bg-yellow-900 mx-auto rounded-full w-24 h-24">
                    <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="mb-4 font-bold text-gray-900 dark:text-white text-6xl">403</h1>
            <h2 class="mb-2 font-semibold text-gray-800 dark:text-gray-200 text-2xl">Akses Ditolak</h2>
            <p class="mb-8 max-w-md text-gray-600 dark:text-gray-400">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda
                merasa ini adalah kesalahan.
            </p>

            <!-- Actions -->
            <div class="flex sm:flex-row flex-col justify-center gap-4">
                <a href="{{ url('/') }}"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-medium text-white transition-colors">
                    Kembali ke Beranda
                </a>
                <button onclick="window.history.back()"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 px-6 py-3 rounded-lg font-medium text-gray-800 dark:text-gray-200 transition-colors">
                    Halaman Sebelumnya
                </button>
            </div>

            <!-- Additional Help -->
            <div class="mt-12 text-gray-500 dark:text-gray-400">
                <p class="text-sm">
                    Jika Anda memerlukan akses ke halaman ini, silakan hubungi administrator.
                </p>
            </div>
        </div>
    </div>

    <!-- Dark mode toggle -->
    <div class="top-4 right-4 fixed">
        <button onclick="toggleTheme()"
            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 p-2 rounded-lg text-gray-800 dark:text-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');

            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Initialize theme
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>

</html>
