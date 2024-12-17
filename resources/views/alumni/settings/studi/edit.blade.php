{{-- <x-alumni.child-layout>
    <x-alumni.back-button/>
    <x-alumni.settings-card
    title="Tambah Data Studi"
    >

    <x-alumni.input-select 
    label="Tahun Mulai"
    name="year_start"
    required="true"
    >
    @for ($year = date('Y'); $year >= 1990; $year--)
        <option value="{{ $year }}">{{ $year }}</option>
    @endfor
    </x-alumni.input-select>

    <x-alumni.input-select 
    label="Tahun Selesai"
    name="start"
    required="true"
    >
    <option value="2021">2021</option>
    <option value="2022">2022</option>
    <option value="2023">2023</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
    <option value="2027">2027</option>
    <option value="2028">2028</option>
    </x-alumni.input-select>

    </x-alumni.settings-card>
</x-alumni.child-layout> --}}