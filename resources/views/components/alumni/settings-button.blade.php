@props([
    'href' => null,
    'type' => null,
    'icon' => null,  
    'title',
    'subtitle',
    'color' => 'bg-secondary'
])

<a @if($href) href="{{ $href }}" @endif class="block">
    <button class="px-4 py-3 {{ $color }} w-full rounded-lg flex items-center justify-between cursor-pointer" @if($type == "submit") type="{{ $type }}" @endif>
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
            </svg>
          </div>
          <div class="">
            <p class="text-white font-bold text-left">{{ $title }}</p>
            <p class="text-white/80 text-sm">{{ $subtitle }}</p>
          </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</a>
  