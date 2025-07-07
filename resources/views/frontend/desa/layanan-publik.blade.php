@extends('frontend.desa.layouts.main')

@section('title', 'Layanan Publik - ' . ($desa->jenis == 'desa' ? 'Desa' : 'Kelurahan') . ' ' . $desa->nama)

@section('content')
    <div class="mx-auto px-4 py-8 container">
        <div class="mb-8">
            <h1 class="mb-2 font-bold text-gray-900 dark:text-white text-3xl">
                Layanan Publik {{ $desa->jenis == 'desa' ? 'Desa' : 'Kelurahan' }} {{ $desa->nama }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Layanan publik yang disediakan untuk masyarakat
            </p>
        </div>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @forelse($layanan as $item)
                <div
                    class="bg-white dark:bg-gray-800 shadow-md hover:shadow-lg rounded-lg overflow-hidden transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            @if ($item->getFirstMediaUrl('icon'))
                                <img src="{{ $item->getFirstMediaUrl('icon') }}" alt="{{ $item->nama }}"
                                    class="mr-4 rounded-full w-12 h-12 object-cover">
                            @else
                                <div
                                    class="flex justify-center items-center bg-primary-100 dark:bg-gray-700 mr-4 rounded-full w-12 h-12">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6 text-primary-500 dark:text-primary-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                            @endif
                            <h3 class="font-semibold text-gray-900 dark:text-white text-xl">{{ $item->nama }}</h3>
                        </div>

                        <p class="mb-4 text-gray-600 dark:text-gray-300">{{ $item->deskripsi }}</p>

                        <div class="flex justify-between mb-4 text-gray-500 dark:text-gray-400 text-sm">
                            <div>
                                <span class="font-semibold">Waktu:</span> {{ $item->waktu_layanan }}
                            </div>
                            <div>
                                <span class="font-semibold">Biaya:</span> {{ $item->biaya }}
                            </div>
                        </div>

                        <button
                            class="bg-primary-500 hover:bg-primary-600 px-4 py-2 rounded-md w-full text-white transition-colors"
                            onclick="toggleDetail('layanan-{{ $item->id }}')">
                            Detail Layanan
                        </button>

                        <div id="layanan-{{ $item->id }}"
                            class="hidden bg-gray-50 dark:bg-gray-700 mt-4 p-4 rounded-md">
                            <div class="mb-4">
                                <h4 class="mb-2 font-semibold text-gray-900 dark:text-white">Persyaratan:</h4>
                                <div class="max-w-none text-gray-600 dark:text-gray-300 prose prose-sm">
                                    {!! $item->persyaratan !!}
                                </div>
                            </div>

                            <div>
                                <h4 class="mb-2 font-semibold text-gray-900 dark:text-white">Prosedur:</h4>
                                <div class="max-w-none text-gray-600 dark:text-gray-300 prose prose-sm">
                                    {!! $item->prosedur !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada layanan publik yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $layanan->links() }}
        </div>
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
