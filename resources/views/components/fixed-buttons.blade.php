{{-- Fixed Buttons: Visitor Stats & Pengaduan --}}
<div class="bottom-6 z-50 fixed inset-x-6">
    <div class="flex justify-between items-end">
        {{-- Pengaduan Button (Left) --}}
        <div class="relative">
            <a href="{{ route('desa.pengaduan', $desa->uri) }}"
                class="group flex items-center space-x-3 bg-red-500 hover:bg-red-600 shadow-lg px-4 py-3 rounded-full font-medium text-white hover:scale-105 transition-all duration-300 transform">
                <div class="bg-white bg-opacity-20 p-2 rounded-full">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6" />
                </div>
                <span class="hidden group-hover:block">Pengaduan</span>
            </a>
        </div>

        {{-- Visitor Stats Button (Right) --}}
        <div class="relative">
            <button onclick="toggleVisitorStats()"
                class="group flex items-center space-x-3 bg-blue-500 hover:bg-blue-600 shadow-lg px-4 py-3 rounded-full font-medium text-white hover:scale-105 transition-all duration-300 transform">
                <div class="bg-white bg-opacity-20 p-2 rounded-full">
                    <x-heroicon-o-eye class="w-6 h-6" />
                </div>
                <span class="hidden group-hover:block">Pengunjung</span>
            </button>

            {{-- Visitor Stats Modal --}}
            <div id="visitor-stats-modal"
                class="right-0 bottom-full absolute bg-white dark:bg-gray-800 shadow-xl mb-4 p-6 border border-gray-200 dark:border-gray-700 rounded-lg w-72 scale-0 origin-bottom-right transition-all duration-300 transform">
                <div class="mb-4">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                        Statistik Pengunjung
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        {{ $desa->nama }}
                    </p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Hari Ini</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-today">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Kemarin</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-yesterday">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Minggu Ini</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-week">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Minggu Lalu</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-last-week">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Bulan Ini</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-month">-</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300 text-sm">Bulan Lalu</span>
                        <span class="font-semibold text-gray-900 dark:text-white" id="visitors-last-month">-</span>
                    </div>
                    <hr class="border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-gray-900 dark:text-white text-sm">Total Kunjungan</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400" id="visitors-total">-</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-gray-200 dark:border-gray-700 border-t">
                    <p class="text-gray-500 dark:text-gray-400 text-xs text-center">
                        Data diperbarui secara real-time
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Fixed Buttons --}}
<script>
    let visitorStatsOpen = false;

    function toggleVisitorStats() {
        const modal = document.getElementById('visitor-stats-modal');

        if (!visitorStatsOpen) {
            // Load visitor stats
            loadVisitorStats();
            // Show modal
            modal.classList.remove('scale-0');
            modal.classList.add('scale-100');
            visitorStatsOpen = true;

            // Close when clicking outside
            setTimeout(() => {
                document.addEventListener('click', closeOnClickOutside);
            }, 100);
        } else {
            closeVisitorStats();
        }
    }

    function closeVisitorStats() {
        const modal = document.getElementById('visitor-stats-modal');
        modal.classList.remove('scale-100');
        modal.classList.add('scale-0');
        visitorStatsOpen = false;
        document.removeEventListener('click', closeOnClickOutside);
    }

    function closeOnClickOutside(event) {
        const modal = document.getElementById('visitor-stats-modal');
        const button = event.target.closest('button');

        if (!modal.contains(event.target) && button?.onclick !== toggleVisitorStats) {
            closeVisitorStats();
        }
    }

    async function loadVisitorStats() {
        try {
            const response = await fetch('{{ route('desa.visitor.stats', $desa->uri) }}');
            const data = await response.json();

            document.getElementById('visitors-today').textContent = data.today || '0';
            document.getElementById('visitors-yesterday').textContent = data.yesterday || '0';
            document.getElementById('visitors-week').textContent = data.week || '0';
            document.getElementById('visitors-last-week').textContent = data.lastWeek || '0';
            document.getElementById('visitors-month').textContent = data.month || '0';
            document.getElementById('visitors-last-month').textContent = data.lastMonth || '0';
            document.getElementById('visitors-total').textContent = data.total || '0';
        } catch (error) {
            console.error('Error loading visitor stats:', error);
            // Show error state
            ['today', 'yesterday', 'week', 'last-week', 'month', 'last-month', 'total'].forEach(period => {
                const element = document.getElementById(`visitors-${period}`);
                if (element) element.textContent = 'Error';
            });
        }
    }

    // Close modal when pressing escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && visitorStatsOpen) {
            closeVisitorStats();
        }
    });
</script>
