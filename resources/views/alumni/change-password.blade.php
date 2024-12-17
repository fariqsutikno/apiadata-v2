{{-- <form action="{{ route('requestOtp')}}" method="post">
    @csrf
    <input type="text" name="whatsapp">
    <button type="submit">Submit</button>
</form> --}}

<x-alumni.child-layout>
    <form action="{{ route('setupPassword')}}" method="post">
        @csrf
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 border border-gray-200">
            <!-- Stepper -->
                <div class="flex flex-col items-center mb-6">
                    <div class="flex flex-row gap-2">
                        <div class="bg-primary text-white rounded-full p-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>                      
                        </div>
                        <div class="bg-gray-600 w-2/3 h-1"></div>
                    </div>
                    <div class="flex flex-col mb-2 items-center text-center">
                        <h2 class="text-gray-700 text-sm">Langkah 1 <span class="text-gray-400">dari 2</span></h2>
                        <h1 class="text-xl font-semibold">Ganti Password</h1>
                        <p class="text-gray-500 text-md mt-2">Ganti password dulu biar aman dan ga gampang ditebak! 😁</p>
                    </div>
                </div>
    
            {{-- <!-- Judul -->
            <h1 class="text-2xl font-bold text-center text-primary mb-3">Ganti Password</h1>
            <p class="text-gray-600 text-center text-sm mb-6">Ganti password dulu biar aman dan ga gampang ditebak! 😁</p> --}}
    
            <!-- Form -->
            <div class="space-y-4 mb-6">
                {{-- <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                        required
                        placeholder="Masukkan password lama"
                    >
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input 
                        type="password" 
                        id="new_password" 
                        name="new_password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                        required
                        placeholder="Minimal 8 karakter"
                    >
                </div> --}}
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required
                            placeholder="Masukin password lama"
                        >
                        <button 
                            type="button" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-all duration-300"
                            onclick="togglePasswordVisibility('current_password')"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3  0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        </button>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-secondary to-secondary border border-gray-300 px-4 py-4 rounded-lg relative mb-4 shadow-lg transition-transform transform hover:scale-105">
                    <div class="flex items-center gap-4">
                        <span>🧏‍♂️</span>
                        <p class="text-sm text-white" style="line-height: 1.4em;">Password baru harus memiliki minimal 8 karakter dengan mengandung huruf besar, huruf kecil, angka, dan karakter spesial</p>
                    </div>
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required
                            placeholder="Minimal 8 karakter, huruf, angka & simbol"
                        >
                        <button 
                            type="button" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-all duration-300"
                            onclick="togglePasswordVisibility('new_password')"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3  0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        </button>
                    </div>

                </div>
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300"
                            required
                            placeholder="Ulangi password baru"
                        >
                        <button 
                            type="button" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-all duration-300"
                            onclick="togglePasswordVisibility('new_password_confirmation')"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3  0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 eye-icon hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Submit Button -->
            <div class="flex flex-row space-x-4 text-center">
                <button class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all" type="submit">
                    Simpan
                </button>
            </div>
        </div>
    </form>
    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const icons = document.querySelectorAll('.eye-icon');
    
            if (input.type === 'password') {
                input.type = 'text';
                icons[0].classList.add('hidden');
                icons[1].classList.remove('hidden');
            } else {
                input.type = 'password';
                icons[0].classList.remove('hidden');
                icons[1].classList.add('hidden');
            }
        }
    </script>
</x-alumni.child-layout>