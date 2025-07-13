@extends('frontend.desa.layouts.main')

@section('title', 'Metadata Statistik - ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">Metadata Statistik</h1>
            <p class="text-muted-foreground">Informasi metadata statistik {{ $desa->nama }}</p>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-3">
            <!-- Metadata Kegiatan -->
            <div class="bg-card border border-border shadow-sm rounded-lg overflow-hidden">
                <div class="bg-primary p-4">
                    <h2 class="font-semibold text-primary-foreground text-xl">Metadata Kegiatan</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata kegiatan berisi informasi tentang seluruh kegiatan statistik yang dilakukan oleh desa.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'kegiatan']) }}"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 w-full">
                        Lihat Metadata Kegiatan
                    </a>
                </div>
            </div>

            <!-- Metadata Indikator -->
            <div class="bg-card border border-border shadow-sm rounded-lg overflow-hidden">
                <div class="bg-secondary p-4">
                    <h2 class="font-semibold text-secondary-foreground text-xl">Metadata Indikator</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata indikator berisi informasi tentang indikator-indikator statistik yang digunakan dalam
                        pengukuran.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'indikator']) }}"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 w-full">
                        Lihat Metadata Indikator
                    </a>
                </div>
            </div>

            <!-- Metadata Variabel -->
            <div class="bg-card border border-border shadow-sm rounded-lg overflow-hidden">
                <div class="bg-accent p-4">
                    <h2 class="font-semibold text-accent-foreground text-xl">Metadata Variabel</h2>
                </div>
                <div class="p-6">
                    <p class="mb-4 text-muted-foreground">
                        Metadata variabel berisi informasi tentang variabel-variabel yang digunakan dalam kegiatan
                        statistik.
                    </p>
                    <a href="{{ route('desa.metadata', ['uri' => $desa->uri, 'jenis' => 'variabel']) }}"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-accent text-accent-foreground hover:bg-accent/80 h-10 px-4 py-2 w-full">
                        Lihat Metadata Variabel
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
