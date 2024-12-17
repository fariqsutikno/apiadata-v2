<div>
    <div class="relative mb-4"> 
        <input 
            placeholder="Sri Sultan Hamengkubuwono Manzigard"
            id="search" 
            name="search" 
            type="text" 
            wire:model.live.debounce.500ms="search"
            class="w-full font-medium rounded-xl py-2 px-4 pl-12 mt-2 focus:outline-none focus:ring-2 focus:ring-primary"
        >

        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-3 top-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </div>


    @if ($alumnis)
        @if($alumnis->isNotEmpty())
            <div class="space-y-2">                
                @foreach ($alumnis as $alumni)
                <div class="relative bg-white rounded-2xl shadow-md p-6 transition-all duration-300 hover:shadow-3xl transform hover:-translate-y-2">
                    <a href="{{ route('alumni.detail', $alumni->nism)}}">                
                        <div class="flex items-center space-x-6">
                            <!-- Profile Image -->
                            <div class="relative">
                                <div class="w-16 h-16 overflow-hidden rounded-full border-4 border-white shadow-lg transform transition-transform duration-300 hover:scale-110">
                                    <img 
                                        src="https://drive.google.com/thumbnail?id={{$alumni->photo_link}}" 
                                        alt="Profile Picture"
                                        class="w-full h-full object-cover object-center"
                                    />
                                </div>
                                <div class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                
                            <!-- Profile Content -->
                            <div class="flex-1 space-y-1">
                                <h2 class="text-xl font-bold text-secondary leading-6">
                                        {{ $alumni->full_name}} 
                                </h2>
                                <p class="text-xs text-gray-600"> {{ $alumni->gen_name}}</p>
                            </div>
                
                            <!-- Navigation Arrow -->
                            <div class="self-center">
                                <button class="p-2 rounded-full bg-secondary/25 text-secondary hover:bg-secondary hover:text-white transition-colors duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </a>        
                </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-center text-gray-600">Datanya ga ketemu, rek!</p>
        @endif
    @endif

</div>