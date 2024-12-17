<a href="{{ $href }}">
    <button class="card-hover group w-full" >
        <div class="bg-gradient-to-br from-{{ $color }} to-{{ $color }}/80 p-6 rounded-2xl 
                    transition-all duration-300 ease-in-out
                    hover:from-{{ $color }}/90 hover:to-{{ $color }} 
                    hover:shadow-lg hover:shadow-{{ $color }}/20
                    relative overflow-hidden">
            <!-- Ripple Effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent
                        translate-x-[-100%] group-hover:translate-x-[100%] 
                        transition-transform duration-1000"></div>
            
            <!-- Content Container -->
            <div class="relative flex flex-col items-start text-left">
                <!-- Icon Container -->
                <div class="icon-hover w-12 h-12 flex items-left justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                            class="h-8 w-8 text-white transition-all duration-300 
                                group-hover:text-white/90" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="{{ $icon }}" />
                    </svg>
                </div>
                <!-- Text Container -->
                <div class="space-y-1">
                    <h3 class="text-white font-bold text-lg transform transition-all duration-300 
                                group-hover:translate-x-1">{{ $title }}</h3>
                    <p class="text-white/70 text-sm transform transition-all duration-300 
                            group-hover:translate-x-1">{{ $subtitle }}</p>
                </div>
            </div>
        </div>
    </button>
</a>