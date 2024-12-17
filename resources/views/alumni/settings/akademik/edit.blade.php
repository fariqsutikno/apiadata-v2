<x-alumni.child-layout>
    <x-alumni.back-button />
    <x-alumni.settings-card title="Pilih Kelasmu!">
        <form action="{{ route('settings.akademik.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="">         
                @php
                    $groupedClasses = $classes->groupBy('year');
                @endphp

                @foreach($groupedClasses as $year => $classGroup)
                    <div class="mb-6">
                        <h3 class="text-md font-bold text-secondary mb-1">Tahun Ajaran {{ $year - 1 }}/{{ $year }}</h3>
                        
                        <div class="pl-4">
                            @foreach($classGroup as $class)
                                <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                                    <div class="relative">
                                        <input 
                                            type="checkbox"
                                            name="classes[]"
                                            value="{{ $class->id }}"
                                            {{ in_array($class->id, $myClasses) ? 'checked' : '' }}
                                            class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                                        >
                                    </div>
                                    <span class="group-hover:text-primary transition-colors">
                                        {{ $class->class }} - Ust. {{ $class->teacher }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="flex items-end justify-end">
                <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
            </div>
        </form>        
    </x-alumni.settings-card>
</x-alumni.child-layout>
