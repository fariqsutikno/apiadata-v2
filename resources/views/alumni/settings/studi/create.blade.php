@push('style')

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

<x-alumni.child-layout>
    <x-alumni.back-button/>
    <x-alumni.settings-card
    >

    <div class="px-4">
        @if($method === 'create@studi')
            <h2 class="text-2xl font-semibold mb-4 text-primary">Tambah Data Profil Studi Lanjut</h2>
        @elseif ($method === 'edit@studi')
            <h2 class="text-2xl font-semibold mb-4 text-primary">Ubah Data Profil Studi Lanjut</h2>
        @elseif ($method === 'create@survey')
            <h2 class="text-2xl font-semibold mb-4 text-primary">Tambah Data Survey Studi Lanjut</h2>
        @elseif ($method === 'edit@survey')
            <h2 class="text-2xl font-semibold mb-4 text-primary">Ubah Data Survey Studi Lanjut</h2>
        @endif
    
        @if($method === 'create@survey' || $method === 'edit@survey')
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-xl text-teal-900 px-4 py-3 my-4 shadow-md"
        role="alert">
        <div class="flex">
            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                </svg></div>
            <div>
                <p class="font-bold text-sm">Survei ini buat apa?</p>
                <ul>
                    <li class="text-xs">Simpelnya, dari survei ini, kami ingin tahu, sebenarnya, alumni sudah pernah daftar mana saja? Apakah diterima sesuai dengan plan A? Berapa kali percobaan untuk masuk kuliah? Dari sini, kami bisa mengevaluasi program-program yang sudah berjalan. Jadi, survei ini khusus untuk <b>keinginan data studi.</b></li>
                </ul>
            </div>
        </div>
    </div>
        @endif
    </div>


    <livewire:university-alumni-form :id="$id" :method="$method"/>
    </x-alumni.settings-card>
</x-alumni.child-layout> 
