@props([
    'style' => null,
    'title' => null,
])
<div class="bg-white rounded-3xl p-6 shadow-lg mb-6 {{ $style }}">
    <div class="flex flex-col">
        @if($title)
            <h2 class="text-2xl font-semibold mb-4 text-primary">{{ $title }}</h2>
        @endif
    </div>
    {{ $slot }}
</div>