<x-filament-widgets::widget>
    <x-filament::section>
        <div class="px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 text-sm leading-6">
                        Berita Terbaru
                    </h3>
                </div>
                <div class="text-right">
                    <a href="{{ route('filament.superadmin.resources.beritas.index') }}"
                        class="text-primary-600 hover:text-primary-500 dark:text-primary-400 text-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>

            <div class="space-y-3 mt-4">
                @forelse($this->getData()['berita'] as $item)
                    <div class="flex items-start space-x-3 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                        @if ($item->gambar_utama)
                            <img src="{{ Storage::url($item->gambar_utama) }}" alt="{{ $item->judul }}"
                                class="flex-shrink-0 rounded-lg w-12 h-12 object-cover">
                        @else
                            <div
                                class="flex flex-shrink-0 justify-center items-center bg-gray-200 dark:bg-gray-700 rounded-lg w-12 h-12">
                                <x-heroicon-o-newspaper class="w-6 h-6 text-gray-400" />
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate">
                                {{ $item->judul }}
                            </p>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">
                                {{ $item->desa->nama_lengkap }} • {{ $item->published_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex-shrink-0">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                       {{ $item->is_highlight ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                {{ $item->is_highlight ? 'Utama' : 'Biasa' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <x-heroicon-o-newspaper class="mx-auto mb-4 w-12 h-12 text-gray-400" />
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            Belum ada berita yang dipublikasikan
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
