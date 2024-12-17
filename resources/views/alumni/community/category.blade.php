<x-alumni.main-layout>
    <x-alumni.header
    title="{{ $header }}"
    href="{{route('community')}}"
    />


    <div class="pt-4">
        <h3 class="text-3xl font-bold mb-2">{{ $title }}</h3>
        <p class="text-md mb-3">{{ $description }}</p>
    </div>
    
    <div class="mb-4 p-2">
        <h3 class="text-xl font-bold text-primary mb-2">List Komunitas:</h3>
        <div class="w-full">
            @if ($data->isEmpty())
                <span class="text-sm text-gray-600">Belum ada komunitas di sini</span>
            @endif
            @foreach ($data as $d)
            <a href="{{ route('community.detail', [$category, $d->slug])}}">            
                <div class="flex flex-row py-3 items-center justify-between border-b">
                  <div class="flex flex-row gap-4">
                      <div class="w-10 h-10 bg-primary/75 rounded-full flex items-center justify-center text-white">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>                              
                      </div>
                      <div>
                        <p class="text-black font-semibold text-md">{{ $d->name }}</p>
                        <p class="text-sm">{{ $d->total_alumni }} orang</p>
                      </div>
                  </div>
                  <div>
                      
                      <p class="text-xl">></p>
                  </div>
                </div>
            </a>            
            @endforeach
        </div>
    </div>
    
</x-alumni.main-layout>
