<x-alumni.child-layout>
    <x-alumni.header
    href="{{ route('settings')}}"
    title="Kelola Minat"
    subtitle="Kelola Minat"
    />

    <x-alumni.settings-card
    title="Minat Saya"
    >
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
        
        <div class="space-y-2">
            @foreach ($myInterests as $myInterest )
                <x-alumni.settings-button
                icon="{{ $myInterest->interest->icon }}"
                title="{{ $myInterest->interest->name }}"
                subtitle=""
                />
            @endforeach
        </div>
        <div class="flex items-end justify-end">
            <a href="{{ route('settings.interest.edit') }}">
                <x-alumni.submit-button>Ubah Minat</x-alumni.submit-button>
            </a>
        </div>
    </x-alumni.settings-card>
</x-alumni.child-layout>
