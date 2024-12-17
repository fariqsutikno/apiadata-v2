<x-alumni.child-layout>
    <x-alumni.header
    title="Riwayat Organisasi"
    subtitle="Riwayat Organisasi"
    href="{{ route('settings')}}"
    ></x-alumni.header>

    <div id="tab1" class="tab-content">
        <x-alumni.settings-card style="mt-3" title="Riwayat Organisasi">
            <div class="w-full">
                @if($organizations)          
                  @foreach ($organizations as $organization)              
                    <div class="flex items-center justify-between py-3 border-b">
                      <div class="flex flex-row gap-4 items-center">
                        <div>
                          <img src="{{ Storage::url($organization->organization->logo)}}" alt="" class="w-12 h-12 rounded-full border-2 border-white bg-gray-200">
                        </div>
                        <div>
                          <p class="text-black font-semibold text-md">{{ $organization->organization->name }}</p>
                          <p class="text-sm">{{ $organization->position }}</p>
                          <p class="text-gray-600 text-xs">{{ $organization->start}} - {{ $organization->end }}</p>
                        </div>
                      </div>
                      <div>
                        <a href="{{ route('settings.organisasi.edit', $organization->id)}}" class="text-gray-500">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                          </svg>                          
                        </a>
                      </div>
                    </div>
                  @endforeach
                @endif
                @if(!$organizations)
                <div class="px-6 py-2">
                  <span class="text-sm text-gray-600">Belum ada data organisasi sejauh ini..." class="text-primary">di sini</a>.</span>
                </div>
                @endif
              </div>
            <div class="flex items-end justify-end">
                <a href="{{ route('settings.organisasi.create')}}">
                    <x-alumni.submit-button style="w-full">Tambahkan</x-alumni.submit-button>
                </a>
            </div>
        </x-alumni.settings-card>
    </div>
</x-alumni.child-layout>
