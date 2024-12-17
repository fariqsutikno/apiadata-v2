<x-alumni.main-layout>
    {{-- <x-alumni.header
    title=""
    href="{{route('dashboard')}}"
    /> --}}


    <h3 class="text-3xl font-bold my-4">Cari komunitas apa?</h3>
    {{-- <p class="text-lg mb-3">Cari relasi dari komunitas alumni</p> --}}

    <x-alumni.input-text 
    placeholder="Cari komunitas"
    icon="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
    name="search"
    />

    <h3 class="text-xl font-medium mb-3 text-gray-800">Komunitas berdasarkan...</h3>
    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('community.category', 'byMajma')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">👥 Majma & JT</a>
        <a href="{{ route('community.category', 'byDomisili')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">📍 Kota Domisili</a>
        <a href="{{ route('community.category', 'byKampus')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">🏫 Kampus</a>
        <a href="{{ route('community.category', 'byLokasiKampus')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">📍 Lokasi Kampus</a>
        <a href="{{ route('community.category', 'byRanahStudi')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">🗺️ Ranah Studi</a>
        <a href="{{ route('community.category', 'byMinat')}}" class="px-4 py-2 bg-gray-100 rounded-full text-sm font-medium">💫 Minat</a>
    </div>
    <h3 class="text-xl font-medium mb-3 text-gray-800">Komunitas yang kayaknya cocok buat kamu:</h3>

    {{-- <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">💫 Ranah Minat</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">👥 Majma & JT</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">📍 Kota Domisili</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">🏫 Kampus</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">📍 Lokasi Kampus</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">🗺️ Ranah Studi</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300 mb-6">
        <h3 class="text-xl font-bold mb-4 text-gray-800">📝 Jalur Penerimaan</h3>
        
        <div class="flex flex-wrap space-y-2 overflow-y-auto max-h-56">
            <x-alumni.community-button
            href=""
            color="cyan-700"
            rank="1"
            title="Univ Gadjah"
            subtitle="20 Orang"
            ></x-alumni.community-button>
        </div>
    
        <a href="#" class="inline-block mt-6 text-primary font-medium transition-colors duration-200">
            Lebih Lengkap
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div> --}}
    
</x-alumni.main-layout>
