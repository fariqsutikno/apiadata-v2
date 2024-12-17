@props([
    'href' => null,
    'title',
    'subtitle' => null,
])
<!-- Header Section -->
<header class="mb-4">
<div class="flex items-center space-x-4 mb-6">
    <a class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition-all" {{ $href ? "href=$href" : "onclick=window.history.back()" }}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    <div>
        <h1 class="text-2xl font-black bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">{{ $title }}</h1>
        <p class="text-gray-400 text-sm">{{ $subtitle }}</p>
    </div>
</div>
</header>