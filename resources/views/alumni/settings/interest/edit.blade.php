<x-alumni.child-layout>
    <x-alumni.back-button />
    <x-alumni.settings-card title="Pilih Minatmu!">
        <form action="{{ route('settings.interest.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="">         
                @foreach($interests as $interest)
                    <label class="flex items-center space-x-4 group cursor-pointer hover:bg-gray-300/50 p-3 rounded-lg transition-all">
                        <div class="relative">
                            <input 
                                type="checkbox"
                                name="interests[]"
                                value="{{ $interest->id }}"
                                {{ in_array($interest->id, $myInterests) ? 'checked' : '' }}
                                class="w-5 h-5 border-2 border-gray-400 rounded focus:ring-primary text-primary transition-colors"
                            >
                        </div>
                        <span class="group-hover:text-primary transition-colors">
                            {{ $interest->name }}
                        </span>
                    </label>
                @endforeach
            </div>
            
            <div class="flex items-end justify-end">
                <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
            </div>
        </form>        
    </x-alumni.settings-card>
</x-alumni.child-layout>
