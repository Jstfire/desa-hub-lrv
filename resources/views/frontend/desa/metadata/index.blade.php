@extends('frontend.desa.layouts.main')

@section('title', 'Metadata Statistik - ' . $desa->nama_lengkap)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">Metadata Statistik</h1>
            <p class="text-muted-foreground">Informasi metadata statistik {{ $desa->nama_lengkap }}</p>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
            <!-- Metadata Kegiatan -->
            <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                <div class="bg-primary p-4">
                    <h2 class="font-semibold text-primary-foreground text-xl">Metadata Kegiatan</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata kegiatan berisi informasi tentang seluruh kegiatan statistik yang dilakukan oleh desa.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'kegiatan']) }}"
                        class="inline-flex justify-center items-center bg-primary hover:bg-primary/90 disabled:opacity-50 px-4 py-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full h-10 font-medium text-primary-foreground text-sm whitespace-nowrap transition-colors disabled:pointer-events-none">
                        Lihat Metadata Kegiatan
                    </a>
                </div>
            </div>

            <!-- Metadata Indikator -->
            <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                <div class="bg-secondary p-4">
                    <h2 class="font-semibold text-secondary-foreground text-xl">Metadata Indikator</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata indikator berisi informasi tentang indikator-indikator statistik yang digunakan dalam
                        pengukuran.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'indikator']) }}"
                        class="inline-flex justify-center items-center bg-secondary hover:bg-secondary/80 disabled:opacity-50 px-4 py-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full h-10 font-medium text-secondary-foreground text-sm whitespace-nowrap transition-colors disabled:pointer-events-none">
                        Lihat Metadata Indikator
                    </a>
                </div>
            </div>

            <!-- Metadata Variabel -->
            <div class="bg-card shadow-sm border border-border rounded-lg overflow-hidden">
                <div class="bg-accent p-4">
                    <h2 class="font-semibold text-xl text-accent-foreground">Metadata Variabel</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata variabel berisi informasi tentang variabel-variabel yang digunakan dalam kegiatan
                        statistik.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'variabel']) }}"
                        class="inline-flex justify-center items-center bg-accent hover:bg-accent/80 disabled:opacity-50 px-4 py-2 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring ring-offset-background focus-visible:ring-offset-2 w-full h-10 font-medium text-sm whitespace-nowrap transition-colors text-accent-foreground disabled:pointer-events-none">
                        Lihat Metadata Variabel
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
