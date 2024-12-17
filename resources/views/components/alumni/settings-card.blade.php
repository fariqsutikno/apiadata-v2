@props([
    'style' => null,
    'title' => null,
])
<div class="bg-white rounded-3xl p-6 shadow-lg mb-6 {{ $style }}">
    @if($title)
        <h2 class="text-2xl font-semibold mb-4 text-primary">{{ $title }}</h2>
    @endif
    {{ $slot }}
</div>