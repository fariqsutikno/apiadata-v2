<x-alumni.main-layout>
    <!-- Header Section -->
    <header class="mb-8 pt-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Sidata+</h1>
                <p class="text-gray-400 text-md mt-1">Ahlaann, {{ $alumni->alias }}</p>
            </div>
            <!-- Profile Image -->
            <div class="relative">
              <div class="w-14 h-14 overflow-hidden rounded-full border-2 border-white shadow-lg transform transition-transform duration-300 hover:scale-110">
                  <img 
                      src="https://drive.google.com/thumbnail?id={{$alumni->photo_link}}" 
                      alt="Profile Picture"
                      class="w-full h-full object-cover object-center"
                  />
              </div>
          </div>
        </div>
      </header>
      
    {{-- <div class="w-108 h-56 relative rounded-xl overflow-hidden bg-gradient-to-r from-gray-700 to-gray-900 p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
          <div class="text-xl font-bold text-white">Status Profil</div>
          <div class="text-sm text-yellow-400">25% Lengkap</div>
        </div>
      
        <!-- Progress Bar -->
        <div class="w-full h-2 bg-gray-600 rounded-full mb-4">
          <div class="w-1/4 h-full bg-yellow-400 rounded-full"></div>
        </div>
      
        <!-- Checklist Status -->
        <div class="space-y-2">
          <div class="flex items-center text-sm">
            <div class="w-4 h-4 rounded-full bg-green-500 mr-2 flex items-center justify-center">
              <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <span class="text-gray-200">Data Pribadi</span>
          </div>
      
          <div class="flex items-center text-sm">
            <div class="w-4 h-4 rounded-full bg-gray-600 mr-2"></div>
            <span class="text-gray-400">Riwayat Pendidikan</span>
          </div>
      
          <div class="flex items-center text-sm">
            <div class="w-4 h-4 rounded-full bg-gray-600 mr-2"></div>
            <span class="text-gray-400">Riwayat Pekerjaan</span>
          </div>
      
          <div class="flex items-center text-sm">
            <div class="w-4 h-4 rounded-full bg-gray-600 mr-2"></div>
            <span class="text-gray-400">Upload Dokumen</span>
          </div>
        </div>
      
        <!-- Action Button -->
        <button class="absolute bottom-4 right-4 bg-yellow-500 hover:bg-yellow-600 text-black font-medium px-4 py-1.5 rounded-lg text-sm transition-colors">
          Lengkapi Profil
        </button>
    </div> --}}
      

    <div class="w-108 h-56 relative rounded-2xl overflow-hidden bg-cover bg-center p-6 transform hover:scale-105 transition-transform duration-300 mx-auto my-6" 
    style="background-image: url('{{ Storage::url($photoCard)}}'); background-size:cover">
      <!-- Background pattern -->
      <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0 mix-blend-overlay"></div>
      </div>
      
        <!-- Chip & Logo -->
        <div class="flex justify-between items-start mb-8">
          {{-- <div class="w-12 h-12 bg-yellow-200/30 rounded-md backdrop-blur-sm border border-yellow-200/30"></div> --}}
          <div></div>
          <div class="text-2xl font-bold {{ $alumni->gen_id == 1 ? 'text-secondary' : ($alumni->gen_id == 4 ? 'text-black' : 'text-white') }}">HAPIA+</div>
        </div>
      
        <!-- Nomor Alumni -->
        <div class="mb-6">
          <div class="text-lg tracking-widest {{ $alumni->gen_id == 1 ? 'text-secondary/70' : ($alumni->gen_id == 4 ? 'text-black' : 'text-gray-300') }} font-mono">
            {{ $alumni->alumni_code}}
          </div>
        </div>
      
        @php
          $name = $alumni->full_name;
          $formattedName = strlen($name) > 30 ? substr($name, 0, 30) . '...' : $name;
        @endphp
        <!-- Info Alumni -->
        <div class="flex justify-between items-end">
          <div class="space-y-1">
              <p class="text-xs uppercase {{ $alumni->gen_id == 1 ? 'text-secondary/70' : ($alumni->gen_id == 4 ? 'text-black' : 'text-gray-400') }}">
                  Nama Alumni
              </p>
              <p class="text-sm font-medium tracking-wider {{ $alumni->gen_id == 1 ? 'text-secondary' : ($alumni->gen_id == 4 ? 'text-black' : 'text-white') }}" id="name">
                  {{strtoupper($formattedName)}}
              </p>
          </div>
      
          <div class="text-right">
              <p class="text-xs uppercase {{ $alumni->gen_id == 1 ? 'text-secondary/70' : ($alumni->gen_id == 4 ? 'text-black' : 'text-gray-400') }}">
                  {{ $alumni->gen->name }}
              </p>
              <p class="text-sm font-medium {{ $alumni->gen_id == 1 ? 'text-secondary' : ($alumni->gen_id == 4 ? 'text-black' : 'text-white') }}">
                  {{ $alumni->gen->year - 1 . '/' . $alumni->gen->year }}
              </p>
          </div>
      </div>
    </div>

    <div class="mb-4">
      <h1 class="text-3xl font-bold text-primary">Mau cari apa hari ini?</h1>
    </div>
    <!-- Grid Container -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <!-- Card 1 -->
        <x-alumni.quick-link-home 
        href="{{ route('community')}}" 
        color="primary" 
        title="Komunitas" 
        subtitle="Temukan orang dengan latar belakang sama!"
        icon="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z">
        </x-alumni.quick-link-home>
          
        <!-- Card 2 -->
        <x-alumni.quick-link-home 
          href="{{ route('survey.index')}}" 
          color="secondary" 
          title="Isi Survey" 
          subtitle="Sharing pendapatmu, dong!"
          icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
        </x-alumni.quick-link-home>
        
        <x-alumni.quick-link-home 
            href="{{ route('settings.studi.create')}}" 
            color="secondary" 
            title="Laporkan Data Studi Terbaru" 
            subtitle=""
            icon="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z">
        </x-alumni.quick-link-home>
        
        <x-alumni.quick-link-home 
            href="" 
            color="primary" 
            title="Panduan Penggunaan" 
            subtitle=""
            icon="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z">
        </x-alumni.quick-link-home>        

        <!-- Card 3 -->
        <x-alumni.quick-link-home 
            href="#" 
            color="gray-400" 
            title="Pengajuan Berkas" 
            subtitle="[Segera Hadir!]"
            icon="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
        </x-alumni.quick-link-home>          

    </div>
</x-alumni.main-layout>