<x-alumni.child-layout>
    <x-alumni.back-button />
    <x-alumni.settings-card
    title="Survei Kelanjutan Studi">
        <form action="{{ route('survey.first.store')}}" method="POST" class="space-y-6">
            @csrf 
    
            <div class="" x-data="{ currentStep: 1 }">
                <!-- Header Section -->
                <header class="mb-8">
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div class="text-xs text-gray-400">Progress</div>
                            <div class="text-xs text-gray-400" x-text="`${currentStep}/5`"></div>
                        </div>
                        <div class="flex h-2 mb-4 overflow-hidden rounded-full bg-gray-800">
                            <div class="transition-all duration-500 bg-gradient-to-r from-primary to-secondary"
                                :style="`width: ${(currentStep / 5) * 100}%`">
                            </div>
                        </div>
                    </div>
                </header>
                
        
                <!-- Form Sections -->
                <div class="space-y-6 mb-4">
                    <!-- Step 1: Personal Information -->
                    <div x-show="currentStep === 1" class="space-y-6">
                        <div class="pl-4">
                                <h3 class="text-sm font-bold text-secondary mb-1">Soal 1 dari 5:</h3>
                                <h3 class="text-md font-medium mb-2">Apa faktor yang paling mempengaruhi Anda dalam pemilihan kampus?</h3>
                                @foreach ($univ_factor as $key =>  $value)                                    
                                <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                                    <div class="relative">
                                        <input 
                                            type="checkbox"
                                            name="univ_factor[]"
                                            value="{{ $key }}"
                                            class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                                        >
                                    </div>
                                    <span class="group-hover:text-primary transition-colors">
                                        {{ $value }}
                                    </span>
                                </label>
                                @endforeach
                        </div>
                    </div>
        
                    <!-- Step 2: Education Details -->
                    <div x-show="currentStep === 2" class="space-y-6">
                        <div class="pl-4">
                            <h3 class="text-sm font-bold text-secondary mb-1">Soal 2 dari 5:</h3>
                            <h3 class="text-md font-medium mb-2">Apa faktor yang paling mempengaruhi Anda dalam pemilihan prodi?</h3>
                            @foreach ($program_factor as $key =>  $value)                                    
                            <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                                <div class="relative">
                                    <input 
                                        type="checkbox"
                                        name="program_factor[]"
                                        value="{{ $key }}"
                                        class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                                    >
                                </div>
                                <span class="group-hover:text-primary transition-colors">
                                    {{ $value }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
        
                    <!-- Step 3: Professional Information -->
                    <div x-show="currentStep === 3" class="space-y-6">
                        <div class="pl-4">
                            <h3 class="text-sm font-bold text-secondary mb-1">Soal 3 dari 5:</h3>
                            <h3 class="text-md font-medium mb-2">Program apa yang Anda ikuti selama perkuliahan?</h3>
                            @foreach ($activity as $key =>  $value)                                    
                            <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                                <div class="relative">
                                    <input 
                                        type="checkbox"
                                        name="activity[]"
                                        value="{{ $key }}"
                                        class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                                    >
                                </div>
                                <span class="group-hover:text-primary transition-colors">
                                    {{ $value }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
        
                    <!-- Step 4: Additional Information -->
                    <div x-show="currentStep === 4" class="space-y-6">
                        <div class="pl-4">
                            <h3 class="text-sm font-bold text-secondary mb-1">Soal 4 dari 5:</h3>
                            <h3 class="text-md font-medium mb-2">Menurut Anda, apa program PIA yang paling berpengaruh bagi kelanjutan studi Anda?</h3>
                            @foreach ($pia_impact as $key =>  $value)                                    
                            <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                                <div class="relative">
                                    <input 
                                        type="checkbox"
                                        name="pia_impact[]"
                                        value="{{ $key }}"
                                        class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                                    >
                                </div>
                                <span class="group-hover:text-primary transition-colors">
                                    {{ $value }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 5: Kritik Saran -->
                    <div x-show="currentStep === 5" class="space-y-6">
                        <div class="pl-4">
                            <h3 class="text-sm font-bold text-secondary mb-1">Soal 5 dari 5:</h3>
                            <h3 class="text-md font-medium mb-2">Sampaikan uneg-unegmu, kendala, atau kritik saran yang berkaitan dengan studi lanjutmu (sekarang atau nanti) dan pengelolaannya di MAS Al Irsyad</h3>
                            <div class="relative" x-data="{ charCount: 0 }">
                                <textarea 
                                    id="kritik" 
                                    name="kritik"
                                    rows="6" 
                                    maxlength="1500"
                                    x-on:input="charCount = $event.target.value.length"
                                    x-init="charCount = $el.value.length"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-700 focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all resize-none"
                                    required
                                ></textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-500">
                                    <span x-text="charCount"></span>/1500
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <!-- Navigation Buttons -->
                <div class="flex justify-between">
                    <button 
                        type="button"  
                        x-show="currentStep > 1"
                        @click="currentStep--"
                        class="px-6 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 transition-all text-gray-300">
                        Previous
                    </button>
                    
                    <button 
                        type="button"  
                        x-show="currentStep < 5"
                        @click="currentStep++"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-secondary hover:opacity-90 transition-all text-white ml-auto">
                        Next
                    </button>
        
                    <button 
                        type="submit"
                        x-show="currentStep === 5"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-secondary hover:opacity-90 transition-all text-white ml-auto">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </x-alumni.settings-card>
</x-alumni.child-layout>