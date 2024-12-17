@props([
    'style' => null,
    'type' => null,
    'color' => 'bg-primary',
    'javascript' => null,
])

<button class="px-4 mt-4 py-2 rounded-xl {{ $color }} hover:opacity-90 transition-all text-white ml-auto @if($style) {{ $style }} @endif" type="{{ $type }}" {{ $javascript }}>
{{ $slot }}
</button>