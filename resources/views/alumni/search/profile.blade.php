@push('style')
<script src="https://kit.fontawesome.com/f40604d63e.js" crossorigin="anonymous"></script>
@endpush
<x-alumni.main-layout>
    <x-alumni.header
      title="Profil Alumni"
      subtitle="Makin kenal dengan sesama alumni irsyadi!"
      href="{{ route('dashboard')}}"
    ></x-alumni.header>  
  
    <div class="container p-4">    
      <!-- Profile Card -->
      <div class="bg-white rounded-3xl p-6 shadow-lg mb-6">
        <div class="flex flex-row items-center gap-4">
          <div class="relative">
            <div class="w-14 h-14 rounded-full overflow-hidden mb-3">
              <img src="https://drive.google.com/thumbnail?id={{$alumni->photo_link}}" 
                   alt="Profile" 
                   class="w-full h-full object-cover"/>
            </div>
            <div class="absolute bottom-1 -right-1 bg-blue-500 rounded-full p-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
          </div>
          </div>
          <div>
            <h2 class="text-xl font-semibold">{{ $alumni->full_name }}</h2>
            <p class="text-gray-600 text-xs mb-4">Angkatan {{ $alumni->gen->name }}</p>
          </div>
        </div>

        <!-- Akademik Section -->
        <div class="flex justify-between items-center py-3 border-b">
          <span class="text-gray-600">Riwayat Akademik</span>
          <div class="flex items-center gap-2">
            <div>
              @if($myClasses->isNotEmpty())
                @foreach ($myClasses as $myClass)
                  <span class="px-2 py-1 bg-gray-100 rounded-full text-xs"> {{ $myClass }} </span>
                @endforeach
              @endif

              @if($myClasses->isEmpty())
                <span class="text-xs text-gray-600">Data belum diisi</span>
              @endif
            </div>
            @if($myClasses->isNotEmpty())
            <span class="text-gray-400">›</span>
            @endif
          </div>
        </div>

        <!-- Kontak Section -->
        <div class="flex justify-between items-center py-3 border-b">
          <span class="text-gray-600">Kontak</span>
          <div class="flex items-center gap-2">
            @if ($alumni->whatsapp)              
              <a href="https://wa.me/{{ $alumni->whatsapp }}" class="text-green-500 hover:text-green-600 transition-colors duration-200">
                  <svg class="w-6 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
              </a>
            @endif
            @if ($alumni->linkedin)              
              <a href="{{ $alumni->linkedin }}" class="text-blue-600 hover:text-blue-700 transition-colors duration-200 ">
                <svg class="w-6 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
              </a>
            @endif
            @if(empty($alumni->linkedin) && empty($alumni->whatsapp))
              <span class="text-xs text-gray-600">Belum ada data</span>
            @endif
          </div>
        </div>

        <!-- Alamat Section -->
        <div class="flex justify-between items-center gap-24 py-3">
          <span class="text-gray-600">Alamat</span>
          <div class="flex items-center">
            @if ($alumni->address)              
              <p class="text-xs text-gray-600 text-right">{{ $alumni->address }}{{ $alumni->country_id == 1 ? ', ' . $alumni->regency->name . ', ' . $alumni->province->name . ', ' : ', ' }}{{ $alumni->country->name }}
              </p>
            @endif
          </div>
        </div>
    
      </div>
    
      <!-- Topik Diminati Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold mb-3">Topik yang Diminati</h3>
        </div>
        <div class="flex flex-wrap gap-2">
          @if($myInterests->isNotEmpty())
            @foreach ($myInterests as $myInterest)
              <span class="px-4 py-2 bg-gray-100 rounded-full text-sm">{{ $myInterest }}</span>
            @endforeach
          @endif

          @if($myInterests->isEmpty())
          <span class="p-3 ml-3 text-sm text-gray-600">Beliau belum menambahkan minat sama sekali.</span>
          @endif

        </div>
      </div>

      <!-- Organisasi Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold">Organisasi</h3>
        </div>
        <div class="w-full">
          @if($myOrganizations->isNotEmpty())          
            @foreach ($myOrganizations as $myOrganization)              
              <div class="flex gap-4 py-3 items-center border-b">
                <div>
                  <img src="{{ Storage::url($myOrganization->logo)}}" alt="" class="w-10 h-10 rounded-full border-2 border-white bg-gray-200">
                </div>
                <div>
                  <p class="text-black font-semibold text-md">{{ $myOrganization->name }}</p>
                  <p class="text-sm">{{ $myOrganization->position }}</p>
                  <p class="text-gray-600 text-xs">{{ $myOrganization->start}} - {{ $myOrganization->end }}</p>
                </div>
              </div>
            @endforeach
          @endif
          @if($myOrganizations->isEmpty())
          <div class="px-6 py-4">
            <span class="text-sm text-gray-600">Belum ada data organisasi sejauh ini...</span>
          </div>
          @endif
        </div>
      </div>

      <!-- Studi Lanjut Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold mb-3">Kelanjutan Studi</h3>
        </div>
        <div class="flex gap-4 overflow-x-auto">
          {{-- @if ($myStudies->isEmpty() && $hiddenStudies = 0)
            <div class="px-6 py-2">
              <span class="text-sm text-gray-600">Belum ada data studi lanjut sejauh ini... <br>Tambahin dulu <a href="{{ route('settings.interest.edit')}}" class="text-primary">di sini</a>.</span>
            </div>
          @endif
          @if ($hiddenStudies >= 1)
            <div class="px-6 py-2">
              <span class="text-sm text-gray-600">Beberapa data studi lanjut disembunyikan...</span>
            </div>
          @endif --}}
          @php
              $visibleStudies = $myStudies->where('is_visible', true);
              $hiddenStudies = $myStudies->where('is_visible', false);
          @endphp

          @if($myStudies->isNotEmpty())
            @if ($visibleStudies->isNotEmpty())
                @foreach ($myStudies as $myStudy)            
                  <div class="min-w-[200px] max-w-60 
                      @if ($myStudy->completion_status->value == 'Sedang Berjalan')
                          bg-sky-700
                      @elseif ($myStudy->completion_status->value == 'Lulus')
                          bg-green-700
                      @elseif ($myStudy->completion_status->value == 'Berhenti')
                          bg-zinc-700
                      @else
                          bg-primary
                      @endif
                      p-6 rounded-2xl text-white">
                      
                      <div class="bg-white/20 w-10 h-10 rounded-full flex items-center justify-center mb-4">
                          @if ($myStudy->completion_status->value == 'Sedang Berjalan')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>                  
                          @elseif ($myStudy->completion_status->value == 'Lulus')
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                              </svg>
                          @elseif ($myStudy->completion_status->value == 'Berhenti')
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                          @endif                  
                      </div>
                      <h4 class="font-semibold mb-1">{{ $myStudy->university->name }}</h4>
                      <p class="text-sm mb-2">{{ $myStudy->program->degree }} {{ $myStudy->program->name }}</p>
                      <p class="text-xs mb-4 text-gray-200">{{ $myStudy->month_start_name}} {{ $myStudy->year_start }} - {{$myStudy->month_end ? $myStudy->month_end_name : ''}} {{$myStudy->year_end ? $myStudy->year_end : 'Sekarang'}}</p>
                      
                      @if ($myStudy->completion_status->value == 'Sedang Berjalan')
                          <span class="px-4 py-1 bg-sky-200 text-sky-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                      @elseif ($myStudy->completion_status->value == 'Lulus')
                          <span class="px-4 py-1 bg-green-200 text-green-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                      @elseif ($myStudy->completion_status->value == 'Berhenti')
                          <span class="px-4 py-1 bg-zinc-200 text-zinc-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                      @endif
                  </div>
                @endforeach
            @else
                <p class="text-sm text-gray-600">Data studi lanjut disembunyikan</p>
            @endif
          @endif
          @if ($myStudies->isEmpty())
          <div class="px-6 py-2">
            <span class="text-sm text-gray-600">Data studi lanjut belum ditambahkan...</span>
          </div>
        @endif
        </div>
      </div>

      @if($alumni->emergency_contact)
      <h3 class="text-lg font-semibold mb-3">Lain-Lain</h3>
      <x-alumni.settings-button
      href="https://wa.me/{{ $alumni->emergency_contact }}"
      icon="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"
      title="KONTAK DARURAT!"
      subtitle="HANYA GUNAKAN SAAT DARURAT"
      color="bg-red-800"
      >
      </x-alumni.settings-button>
      @endif
      
  </div>
    
</x-alumni.main-layout>
