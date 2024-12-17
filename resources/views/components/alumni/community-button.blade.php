@props([
    'href' => null,
    'icon' => null,  
    'rank',
    'title',
    'subtitle',
    'color' => '[#C08E65]'
])


<a  @if($href) href="{{ $href }}" @endif class="inline-block px-4 py-3 h-16  w-full rounded-lg border flex items-center justify-between cursor-pointer">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-secondary rounded-full flex items-center justify-center">
            <p class="text-white font-bold">{{ $rank }}</p>
        </div>
        <div class="text-left">
        <p class="text-primary font-bold text-left">{{ $title }}</p>
        <p class="text-black/80 text-sm">{{ $subtitle }}</p>
        </div>
    </div>
</a>

  