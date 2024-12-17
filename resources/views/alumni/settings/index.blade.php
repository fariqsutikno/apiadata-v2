@push('style')
<script src="https://kit.fontawesome.com/f40604d63e.js" crossorigin="anonymous"></script>
@endpush
<x-alumni.main-layout>
    <x-alumni.header
      title="Profil Kamu"
      subtitle="Sesuaiin biar data dan preferensimu akurat!"
      href="{{ route('dashboard')}}"
    ></x-alumni.header>  
  
    <div class="container p-4">    
      <!-- Profile Card -->
      <div class="bg-white rounded-3xl p-6 shadow-lg mb-6">
        <div class="flex flex-row justify-between items-center">
          <div class="flex flex-row items-center gap-4">
            <div class="w-14 h-14 rounded-full overflow-hidden mb-3">
              <img src="https://drive.google.com/thumbnail?id={{$alumni->photo_link}}" 
                   alt="Profile" 
                   class="w-full h-full object-cover"/>
            </div>
            <div>
              <h2 class="text-xl font-semibold">{{ $alumni->full_name }}</h2>
              <p class="text-gray-600 text-xs mb-4">Angkatan {{ $alumni->gen->name }}</p>
            </div>
          </div>
          <div class="justify-self-end">
            <a href="{{ route('settings.identitas')}}">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
              </svg>
          </a>
          </div>
        </div>

        <!-- GDrive Section -->
        <div class="flex justify-between items-center py-3 border-b">
          <span class="text-gray-600">NISN</span>
          <div class="flex items-center gap-2">
            <p class="text-sm">{{ $alumni->nisn }}</p>
          </div>
        </div>

        <!-- Akademik Section -->
        <div class="flex justify-between items-center py-3 border-b">
          <span class="text-gray-600">Riwayat Akademik</span>
          <a href="{{ route('settings.akademik.index')}}">
            <div class="flex items-center gap-2">
              <div>
                @if($myClasses->isNotEmpty())
                  @foreach ($myClasses as $myClass)
                    <span class="px-2 py-1 bg-gray-100 rounded-full text-xs"> {{ $myClass }} </span>
                  @endforeach
                @endif

                @if($myClasses->isEmpty())
                  <span class="px-2 py-1 bg-amber-300 text-amber-800 font-bold rounded-full text-xs">‼️ Isi dulu, klik di sini! ></span>
                @endif
              </div>
              @if($myClasses->isNotEmpty())
              <span class="text-gray-400">›</span>
              @endif
            </div>
          </a>
        </div>

        <!-- GDrive Section -->
        <div class="flex justify-between items-center py-3">
          <span class="text-gray-600">Data Berkas</span>
          <div class="flex items-center gap-2">
            <a href="{{ $alumni->drive_link }}" class="px-2 py-1 bg-blue-100 rounded-full text-xs">🔗 Link Drive</a>
          </div>
        </div>
    
      </div>
    
      <!-- Topik Diminati Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold mb-3">Topik yang Diminati</h3>
          @if($myInterests->isNotEmpty())
            <a href="{{ route('settings.interest.edit')}}" class="text-md text-primary font-medium mb-3">Ubah</a>
          @endif
        </div>
        <div class="flex flex-wrap gap-2">
          @if($myInterests->isNotEmpty())
            @foreach ($myInterests as $myInterest)
              <span class="px-4 py-2 bg-gray-100 rounded-full text-sm">{{ $myInterest }}</span>
            @endforeach
          @endif

          @if($myInterests->isEmpty())
          <span class="p-3 text-sm text-gray-600">Wah, Kamu belum menambahkan minat sama sekali. Tambahin dulu <a href="{{ route('settings.interest.edit')}}" class="text-primary">di sini</a>.</span>
          @endif

        </div>
      </div>

      <!-- Organisasi Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold">Organisasi</h3>
          @if ($myOrganizations->isNotEmpty())
          <a href="{{ route('settings.organisasi.index')}}" class="text-md text-primary font-medium mb-3">Ubah</a>
          @endif
        </div>
        <div class="w-full">
          @if($myOrganizations->isNotEmpty())          
            @foreach ($myOrganizations as $myOrganization)              
              <div class="flex gap-4 py-3 items-center border-b">
                <div>
                  <img src="{{ Storage::url($myOrganization->logo)}}" alt="" class="w-10 h-10 rounded-full border-2 border-white bg-gray-200">
                </div>
                <div>
                  <a href="{{ route('community.detail', ['byMajma', $myOrganization->slug])}}" class="text-black font-semibold text-md">{{ $myOrganization->name }}</p>
                  <p class="text-sm">{{ $myOrganization->position }}</p>
                  <p class="text-gray-600 text-xs">{{ $myOrganization->start}} - {{ $myOrganization->end }}</p>
                </div>
              </div>
            @endforeach
          @endif
          @if($myOrganizations->isEmpty())
          <div class="px-6 py-2">
            <span class="text-sm text-gray-600">Belum ada data organisasi sejauh ini... <br>Tambahin dulu <a href="{{ route('settings.interest.edit')}}" class="text-primary">di sini</a>.</span>
          </div>
          @endif
        </div>
      </div>

      <!-- Studi Lanjut Section -->
      <div class="mb-6">
        <div class="flex flex-row items-center justify-between">
          <h3 class="text-lg font-semibold mb-3">Kelanjutan Studi</h3>
          @if($myStudies->isNotEmpty())
            <a href="{{ route('settings.studi.index')}}" class="text-md text-primary font-medium mb-3">Atur</a>
          @endif
        </div>
        <div class="flex gap-4 overflow-x-auto">
          @if($myStudies->isNotEmpty())
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
                  <p class="text-xs mb-4 text-gray-200">
                    ({{$myStudy->month_start_name . " " .$myStudy->year_start}} - {{$myStudy->completion_status->value === 'Sedang Berjalan' ? 'Sekarang' : $myStudy->month_end_name . ' ' . $myStudy->year_end}})
                  </p>
                  
                  @if ($myStudy->completion_status->value == 'Sedang Berjalan')
                      <span class="px-4 py-1 bg-sky-200 text-sky-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                  @elseif ($myStudy->completion_status->value == 'Lulus')
                      <span class="px-4 py-1 bg-green-200 text-green-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                  @elseif ($myStudy->completion_status->value == 'Berhenti')
                      <span class="px-4 py-1 bg-zinc-200 text-zinc-800 rounded-full text-xs">{{ $myStudy->completion_status }}</span>
                  @endif
              </div>
            @endforeach
          @endif
          @if ($myStudies->isEmpty())
            <div class="px-6 py-2">
              <span class="text-sm text-gray-600">Belum ada data studi lanjut sejauh ini... <br>Tambahin dulu <a href="{{ route('settings.interest.edit')}}" class="text-primary">di sini</a>.</span>
            </div>
          @endif
        </div>
      </div>

      <!-- Lain-Lain Section -->
      <div class="space-y-2">      
        <h3 class="text-lg font-semibold mb-3">Lain-Lain</h3>
        <x-alumni.settings-button
          href="https://wa.me/6287779897434"
          icon="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"
          title="Laporkan Gangguan"
          subtitle=""
        >
        </x-alumni.settings-button>
  
        <form action="{{ route('logout')}}" method="post">
            @csrf
            <x-alumni.settings-button
            type="submit"
            icon="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
            title="Log Out"
            subtitle=""
            >
          </x-alumni.settings-button>
        </form>
      </div>
    
      </div>
    
</x-alumni.main-layout>
