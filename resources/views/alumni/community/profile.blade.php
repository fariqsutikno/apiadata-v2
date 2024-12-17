<x-alumni.main-layout>
    <x-alumni.header
    title=""
    href="{{route('community.category', $category)}}"
    />


    <div class="pt-4">
        <p class="text-lg">Komunitas Alumni:</p>
        <h3 class="text-3xl font-bold mb-2">{{ $title }}</h3>
    </div>

    <div class="mb-4 pt-6 space-y-6">
        @foreach ($data as $angkatan => $alumniList)
        <div class="w-full">
            <h3 class="my-2 font-semibold text-lg text-primary">👉 {{ $angkatan }}</h3>
            @foreach ($alumniList as $alumni)                
            <a href="">            
                <div class="flex flex-row py-3 items-center justify-between border-t border-b"> 
                  <div class="flex flex-row gap-4">
                      <div>
                        <p class="text-black font-semibold text-md">{{ $alumni->alumni_name }}</p>
                        {{-- <p class="text-sm">{{ $alumni->alumni_whatsapp }}</p> --}}
                      </div>
                  </div>
                  <div>
                      <p class="text-xl">></p>
                  </div>
                </div>
            </a>            
            @endforeach
        </div>
        @endforeach
    </div>
    
</x-alumni.main-layout>