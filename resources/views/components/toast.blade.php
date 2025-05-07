<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100);setTimeout(() => show = false, 3000)"
    x-show="show" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
    class="fixed top-14 right-10 z-50 w-full max-w-xs p-4 mb-4 text-base-content bg-base-200 border border-green-200 rounded-lg shadow-lg"
    style="display: none;">

    <div class="flex items-center">
        <div
            class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-full">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 1 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        <div class="ml-3 text-sm font-medium">
            {{ session('success') }}
        </div>
    </div>
</div>