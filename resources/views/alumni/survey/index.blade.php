<x-alumni.child-layout>
    <x-alumni.header title="List Survei" href="{{ route('dashboard') }}" />

    <x-alumni.settings-card>
        @if (!$surveyFirst)
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-xl text-teal-900 px-4 py-3 mb-4 shadow-md"
            role="alert">
            <div class="flex items-center">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg></div>
                <div>
                    <p class="font-bold text-sm">Semua survei ini akan bersifat anonim.</p>
                </div>
            </div>
        </div>
        <h3 class="text-2xl font-semibold mb-4 text-primary">List Survey</h3>
            <x-alumni.settings-button title="Survei Kepuasan Alumni" subtitle=""
                icon="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
                href="{{ route('survey.first.show') }}"></x-alumni.settings-button>
        @endif

        @if ($surveyFirst)
            <div class="mt-3">
                <p class="text-md text-gray-400 text-center">Terima kasih, tidak ada lagi survey yang perlu diisi.</p>
            </div>
        @endif
    </x-alumni.settings-card>
</x-alumni.child-layout>
