@props(['type' => 'grid', 'count' => 6])

@if ($type === 'grid')
    {{-- Grid Skeleton Loader --}}
    <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @for ($i = 0; $i < $count; $i++)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden animate-pulse">
                {{-- Image placeholder --}}
                <div class="bg-gray-300 dark:bg-gray-600 w-full h-48"></div>

                <div class="p-6">
                    {{-- Category badge --}}
                    <div class="mb-3">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full w-20 h-5"></div>
                    </div>

                    {{-- Title --}}
                    <div class="space-y-2 mb-3">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-full h-4"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-3/4 h-4"></div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2 mb-4">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-full h-3"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-5/6 h-3"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-2/3 h-3"></div>
                    </div>

                    {{-- Meta info --}}
                    <div class="flex justify-between items-center">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-24 h-3"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-16 h-3"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@elseif($type === 'list')
    {{-- List Skeleton Loader --}}
    <div class="space-y-6">
        @for ($i = 0; $i < $count; $i++)
            <div class="flex bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden animate-pulse">
                {{-- Image placeholder --}}
                <div class="flex-shrink-0 bg-gray-300 dark:bg-gray-600 w-48 h-32"></div>

                <div class="flex-1 p-6">
                    {{-- Category badge --}}
                    <div class="mb-3">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full w-20 h-5"></div>
                    </div>

                    {{-- Title --}}
                    <div class="space-y-2 mb-3">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-3/4 h-5"></div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-2 mb-4">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-full h-3"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-5/6 h-3"></div>
                    </div>

                    {{-- Meta info --}}
                    <div class="flex justify-between items-center">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-24 h-3"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-16 h-3"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@elseif($type === 'gallery')
    {{-- Gallery Skeleton Loader --}}
    <div class="gap-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @for ($i = 0; $i < $count; $i++)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden animate-pulse">
                {{-- Image placeholder --}}
                <div class="bg-gray-300 dark:bg-gray-600 w-full h-48"></div>

                <div class="p-4">
                    {{-- Title --}}
                    <div class="space-y-2">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-full h-4"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-2/3 h-4"></div>
                    </div>

                    {{-- Date --}}
                    <div class="mt-3">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-20 h-3"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@elseif($type === 'content')
    {{-- Content Skeleton Loader --}}
    <div class="mx-auto max-w-4xl">
        @for ($i = 0; $i < $count; $i++)
            <div class="bg-white dark:bg-gray-800 shadow-lg mb-8 rounded-lg overflow-hidden animate-pulse">
                <div class="p-8">
                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-2/3 h-6"></div>
                        <div class="bg-gray-300 dark:bg-gray-600 rounded-full w-24 h-6"></div>
                    </div>

                    {{-- Content --}}
                    <div class="space-y-3">
                        @for ($j = 0; $j < 5; $j++)
                            <div class="bg-gray-300 dark:bg-gray-600 rounded w-full h-4"></div>
                        @endfor
                        <div class="bg-gray-300 dark:bg-gray-600 rounded w-3/4 h-4"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endif
