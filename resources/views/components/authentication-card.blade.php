<div class="flex flex-col sm:justify-center items-center bg-gray-100 pt-6 sm:pt-0 min-h-screen">
    <div>
        {{ $logo }}
    </div>

    <div class="bg-white shadow-md mt-6 px-6 py-4 sm:rounded-lg w-full sm:max-w-md overflow-hidden">
        {{ $slot }}
    </div>
</div>
