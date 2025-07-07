<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Desa - DesaHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8 text-center">
            <h1 class="mb-4 font-bold text-gray-800 text-4xl">
                <i class="text-blue-600 fas fa-home"></i>
                DesaHub
            </h1>
            <p class="text-gray-600 text-xl">Sistem Informasi Desa Terpadu</p>
            <p class="mt-2 text-gray-500">Silakan pilih desa yang ingin Anda kunjungi</p>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($desas as $desa)
                <div class="bg-white shadow-md hover:shadow-lg rounded-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-gray-800 text-xl">
                                {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
                            </h3>
                            <span
                                class="px-3 py-1 text-sm rounded-full {{ $desa->jenis == 'desa' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($desa->jenis) }}
                            </span>
                        </div>

                        @if ($desa->deskripsi)
                            <p class="mb-4 text-gray-600 line-clamp-3">
                                {{ Str::limit($desa->deskripsi, 100) }}
                            </p>
                        @endif

                        @if ($desa->alamat)
                            <div class="flex items-center mb-4 text-gray-500">
                                <i class="mr-2 fas fa-map-marker-alt"></i>
                                <span class="text-sm">{{ $desa->alamat }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-gray-500">
                                <i class="mr-2 fas fa-link"></i>
                                <span class="font-mono text-sm">{{ $desa->uri }}</span>
                            </div>
                            <a href="/{{ $desa->uri }}"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white transition-colors duration-200">
                                <span>Kunjungi</span>
                                <i class="fa-arrow-right ml-2 fas"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($desas->isEmpty())
            <div class="py-12 text-center">
                <i class="mb-4 text-gray-400 text-6xl fas fa-info-circle"></i>
                <h3 class="mb-2 font-semibold text-gray-600 text-xl">Belum Ada Desa Terdaftar</h3>
                <p class="text-gray-500">Tidak ada desa yang tersedia saat ini.</p>
            </div>
        @endif
    </div>

    <footer class="bg-gray-800 mt-12 text-white">
        <div class="mx-auto px-4 py-6 container">
            <div class="text-center">
                <p>&copy; 2025 DesaHub. Made with <i class="text-red-500 fas fa-heart"></i> by Jstfire.</p>
            </div>
        </div>
    </footer>
</body>

</html>
