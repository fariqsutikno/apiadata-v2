<x-alumni.child-layout>
    <x-alumni.back-button/>
    <x-alumni.settings-card
    title="Tambah Data Majma / JT"
    >

    <form action="{{ route('settings.organisasi.store')}}" method="post">
        @csrf

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        <x-alumni.input-select
        name="organization_id"
        label="Nama Majma / JT"
        :required="true"
        >
        <option value="">Pilih Majma / JT</option>
        @foreach ($organizations as $organization)
            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
        @endforeach
        </x-alumni.input-select>
        
        <div class="flex flex-row gap-4 -mt-3">
            <x-alumni.input-select
                name="start"
                label="Tahun Mulai"
                :required="true"
            >
                <option value="">Pilih Tahun</option>
                @for ($year = 2018; $year <= 2024; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
             
            </x-alumni.input-select>
    
            <x-alumni.input-select
                name="end"
                label="Tahun Berakhir"
                :required="true"
            >
                <option value="">Pilih Tahun</option>
                @for ($year = 2018; $year <= 2024; $year++)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </x-alumni.input-select>
        </div>
        <x-alumni.input-text 
        label="Posisi / Jabatan"
        value="{{ old('position')}}"
        placeholder="Contoh: Reporter / Korlap / Qism Tanfidz"
        name="position"
        type="text"
        :required="true"
        ></x-alumni.input-text>
    
        <x-alumni.submit-button
        style="w-full"
        type="submit"
        >
            Submit
        </x-alumni.submit-button>
    </form>
    

    </x-alumni.settings-card>
</x-alumni.child-layout>