{{-- <form action="{{ route('requestOtp')}}" method="post">
    @csrf
    <input type="text" name="whatsapp">
    <button type="submit">Submit</button>
</form> --}}

<x-alumni.child-layout>
    <form action="{{ route('setup.otp.request')}}" method="post">
        @csrf
        <!-- OTP Verification Section -->
        <div class="rounded-3xl p-6 mt-6 shadow-xl content-animation">
            <!-- Stepper -->
            <div class="">
                <div class="flex flex-col items-center mb-4">
                    <div class="flex flex-row gap-2">
                        <div class="bg-primary text-white rounded-full p-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                              </svg>
                                                 
                        </div>
                        <div class="bg-gray-600 w-2/3 h-1"></div>
                    </div>
                    <div class="flex flex-col mb-2 items-center text-center">
                        <h2 class="text-gray-700 text-sm">Langkah 2 <span class="text-gray-400">dari 2</span></h2>
                        <h1 class="text-xl font-semibold">Atur Kontak Whatsapp</h1>
                        <p class="text-gray-500 text-md mt-2">Masukin no kamu dulu yak, biar gampang silaturahminya. 😇</p>
                    </div>
                </div>
            </div>
            
            <!-- OTP Input Fields -->
            {{-- <div class="flex flex-col justify-center space-x-2 mb-2">
                <input type="text" class="w-full font-medium rounded-xl py-2 px-4 mt-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" placeholder="628123456789" name="whatsapp" autofocus>
            </div> --}}
            <div class="mb-6">
                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">No Whatsapp</label>
                <input 
                    type="text" 
                    id="whatsapp" 
                    name="whatsapp" 
                    class="w-full font-medium rounded-xl py-2 px-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"
                    placeholder="Pake kode negara, contoh: 62857xxxxxx"
                    autofocus
                >
            </div>
            {{-- <p class="text-gray-600 mb-6 text-xs">Tulis pake kode negara di depan yak. Contoh: 62857...., atau 65......</p> --}}

            <!-- Submit Button -->
            <div class="flex flex-row space-x-4 text-center">
                <button class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all" type="submit">
                    Selanjutnya
                </button>
            </div>
        </div>
    </form>
</x-alumni.child-layout>