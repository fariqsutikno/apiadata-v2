<x-alumni.child-layout>
    <x-alumni.header 
    href="{{route('settings')}}"
    title="Survey Kelanjutan Studi"
    subtitle=""
    ></x-alumni.header>

    <x-alumni.settings-card
    title="List Data Survey"
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

    <div class="space-y-3"> 
        @foreach ($myStudies as $myStudy )
                <div class="w-full flex items-center p-3 rounded-xl transition-colors text-left border border-primary rounded-3xl">
                    <div class="w-10 h-10 rounded-full bg-primary/75  flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <a href=""><h3 class="font-semibold">{{$myStudy->university->name}}</h3></a>
                        <p class="text-sm">{{$myStudy->program->degree}} {{$myStudy->program->name}}</p>
                        <p class="text-xs mt-1">
                            ({{$myStudy->year_start}})
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('settings.studi.edit', $myStudy->id)}}">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </a>
                    </div>
                </div>     
        @endforeach
    </div>
    <div>
        <a href="{{ route('survey.studi.create')}}">
            <x-alumni.submit-button style="w-full">Tambah Data</x-alumni.submit-button>
        </a>
    </div>
    </x-alumni.settings-card>
</x-alumni.child-layout>
