<x-alumni.child-layout>
    <x-alumni.header
    title="Riwayat Akademik"
    subtitle="Riwayat Akademik"
    href="{{ route('settings')}}"
    ></x-alumni.header>

    <div id="tab1" class="tab-content">
        <x-alumni.settings-card title="Berkas Akademik">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('settings.identitas.update')}}" method="post">
                @csrf
                <input type="hidden" name="tab" value="tab6">
                <!-- Tab Content -->
                    <div class="flex space-x-4">
                        <x-alumni.input-text 
                            label="Rata-Rata Ijazah MA"
                            value="{{ $alumni->ma_average }}"
                            name="ma_average"
                            type="number"
                            :required="true"
                        ></x-alumni.input-text>
    
                        <x-alumni.input-text 
                            label="Rata-Rata Ijazah IM"
                            value="{{ $alumni->im_average }}"
                            name="im_average"
                            type="number"
                            :required="true"
                        ></x-alumni.input-text>
                    </div>

                    <div class="flex items-end justify-end">
                        <x-alumni.submit-button type="submit">Simpan</x-alumni.submit-button>
                    </div>
            </form>
        </x-alumni.settings-card>
        <x-alumni.settings-card style="mt-3" title="Riwayat Kelas">
            <div class="mb-4 p-2">
                <div class="w-full">
                  @if($classrooms->isNotEmpty())          
                    @foreach ($classrooms as $classroom)              
                      <div class="flex gap-4 py-3 items-center border-b">
                        <div class="w-10 h-10 bg-primary/75 rounded-full flex items-center justify-center text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                              </svg>                              
                        </div>
                        <div>
                          <p class="text-black font-semibold text-md">Kelas {{ $classroom->class }}</p>
                          <p class="text-sm">Ust. {{ $classroom->teacher }} ({{ $classroom->year - 1}}/{{ $classroom->year }})</p>
                        </div>
                      </div>
                    @endforeach
                  @endif
                  @if($classrooms->isEmpty())
                  <div class="px-6 py-2">
                    <p class="text-sm text-center text-gray-600">Belum ada data riwayat kelas sejauh ini... <br>Tambahin dulu... 👇</p>
                  </div>
                  @endif
                </div>
            </div>
            <div class="flex items-end justify-end">
                <a href="{{ route('settings.akademik.edit')}}">
                    <x-alumni.submit-button>{{ $classrooms->isEmpty() ? 'Tambahkan' : 'Ubah'}}</x-alumni.submit-button>
                </a>
            </div>
        </x-alumni.settings-card>
    </div>

</x-alumni.child-layout>
  