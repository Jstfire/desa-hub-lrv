@extends('frontend.desa.layouts.main')

@section('title', 'Layanan Publik - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-foreground text-3xl">
                Layanan Publik {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="text-muted-foreground">
                Layanan publik yang disediakan untuk masyarakat
            </p>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($layanan as $item)
                <div
                    class="bg-card border border-border shadow-sm hover:shadow-md rounded-lg overflow-hidden transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            @if ($item->getFirstMediaUrl('icon'))
                                <img src="{{ $item->getFirstMediaUrl('icon') }}" alt="{{ $item->nama }}"
                                    class="mr-4 rounded-full w-12 h-12 object-cover">
                            @else
                                <div
                                    class="flex justify-center items-center bg-primary/10 mr-4 rounded-full w-12 h-12">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-primary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            @endif
                            <h3 class="font-semibold text-card-foreground text-xl">{{ $item->nama }}</h3>
                        </div>

                        <p class="mb-4 text-muted-foreground">{{ $item->deskripsi }}</p>

                        <div class="flex justify-between mb-4 text-muted-foreground text-sm">
                            <div>
                                <span class="font-semibold">Waktu:</span> {{ $item->waktu_layanan }}
                            </div>
                            <div>
                                <span class="font-semibold">Biaya:</span> {{ $item->biaya }}
                            </div>
                        </div>

                        <button
                            class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-md w-full text-primary-foreground transition-colors"
                            onclick="toggleDetail('layanan-{{ $item->id }}')">
                            Detail Layanan
                        </button>

                        <div id="layanan-{{ $item->id }}"
                            class="hidden bg-muted mt-4 p-4 rounded-md border border-border">
                            <div class="mb-4">
                                <h4 class="mb-2 font-semibold text-card-foreground">Persyaratan:</h4>
                                <div class="max-w-none text-muted-foreground prose prose-sm prose-slate">
                                    {!! $item->persyaratan !!}
                                </div>
                            </div>

                            <div>
                                <h4 class="mb-2 font-semibold text-card-foreground">Prosedur:</h4>
                                <div class="max-w-none text-muted-foreground prose prose-sm prose-slate">
                                    {!! $item->prosedur !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-muted-foreground" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-foreground">Tidak ada layanan</h3>
                    <p class="mt-1 text-sm text-muted-foreground">Belum ada layanan publik yang tersedia.</p>
                </div>
            @endforelse
        </div>

        @if ($layanan->hasPages())
            <div class="mt-8">
                {{ $layanan->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function toggleDetail(id) {
            const element = document.getElementById(id);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
@endsection
