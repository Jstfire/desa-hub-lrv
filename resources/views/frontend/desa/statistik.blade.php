@extends('frontend.desa.layouts.main')

@section('title', 'Statistik Pengunjung - ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="mb-4 font-bold text-foreground text-3xl">Statistik Pengunjung</h1>
            <p class="text-muted-foreground">Data statistik kunjungan website {{ $desa->nama }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center bg-primary/10 rounded-md w-10 h-10">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-muted-foreground text-sm">Hari Ini</h3>
                        <p class="font-bold text-card-foreground text-2xl">{{ number_format($stats['today']) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center bg-primary/10 rounded-md w-10 h-10">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-muted-foreground text-sm">Kemarin</h3>
                        <p class="font-bold text-card-foreground text-2xl">{{ number_format($stats['yesterday']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center bg-primary/10 rounded-md w-10 h-10">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-muted-foreground text-sm">Minggu Ini</h3>
                        <p class="font-bold text-card-foreground text-2xl">{{ number_format($stats['this_week']) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex justify-center items-center bg-primary/10 rounded-md w-10 h-10">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-muted-foreground text-sm">Total Kunjungan</h3>
                        <p class="font-bold text-card-foreground text-2xl">{{ number_format($stats['total']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <h3 class="mb-4 font-semibold text-card-foreground text-lg">Minggu Lalu</h3>
                <p class="font-bold text-primary text-3xl">{{ number_format($stats['last_week']) }}</p>
            </div>

            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <h3 class="mb-4 font-semibold text-card-foreground text-lg">Bulan Ini</h3>
                <p class="font-bold text-primary text-3xl">{{ number_format($stats['this_month']) }}
                </p>
            </div>

            <div class="bg-card border border-border shadow-sm p-6 rounded-lg">
                <h3 class="mb-4 font-semibold text-card-foreground text-lg">Bulan Lalu</h3>
                <p class="font-bold text-primary text-3xl">{{ number_format($stats['last_month']) }}
                </p>
            </div>
        </div>

        <!-- Chart or Graph could be added here -->
        <div class="bg-card border border-border shadow-sm mt-8 p-6 rounded-lg">
            <h3 class="mb-4 font-semibold text-card-foreground text-lg">Grafik Kunjungan 7 Hari Terakhir</h3>
            <p class="text-muted-foreground">Grafik akan ditampilkan di sini (implementasi Chart.js atau library
                lain)</p>
        </div>
    </div>
@endsection
