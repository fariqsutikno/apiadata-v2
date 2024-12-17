{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="nism" :value="__('nism')" />
            <x-text-input id="nism" class="block mt-1 w-full" type="text" name="nism" :value="old('nism')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('nism')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>
    <!-- Dalam tag <head> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <!-- Alpine.js for handling tabs and interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="antialiased bg-gray-900 min-h-screen font-sans bg-login" >
    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen px-4 bg-login overlay"style="background-image: url('{{asset('image/login-bg2.jpg')}}'); background-size: contain;">
        <div class="bg-gray-900 rounded-3xl p-6 shadow-xl border border-gray-800 content-animation w-full max-w-sm">
            <!-- Branding Logo -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Sidata+</h1>
                <p class="text-gray-400">Portal Data Alumni MAS Al Irsyad</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
            
                <!-- Username -->
                <div class="mb-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="nism" 
                            placeholder="Username" 
                            :value="old('nism')" 
                            required 
                            autofocus 
                            class="w-full bg-gray-800 text-white rounded-xl py-3 px-4 pl-12 focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                    <!-- Error Message -->
                    @error('nism')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            
                <!-- Password -->
                <div class="mb-4">
                    <div class="relative">
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Password" 
                            required 
                            autocomplete="current-password"
                            class="w-full bg-gray-800 text-white rounded-xl py-3 px-4 pl-12 focus:outline-none focus:ring-2 focus:ring-primary"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>
                    </div>
                    <!-- Error Message -->
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            
                <!-- Login Button -->
                <div class="text-center mb-4">
                    <button 
                        type="submit" 
                        class="w-full px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all"
                    >
                        Login
                    </button>
                </div>
            </form>

            <!-- Links for Password Recovery and Account Creation -->
            <div class="text-center">
                <a onclick="openModal()" class="text-primary hover:underline">Saya mengalami kendala login</a>
            </div>
        </div>
    </div>
    <!-- Modal Backdrop -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
        <!-- Modal Content -->
        <div id="modalContent" class="modal-animation relative max-w-l max-h-[90vh] bg-gray-900/95 rounded-3xl border border-gray-700/50 shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-primary">Mengalami kendala login?</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="mt-2 text-gray-400 text-sm">Silakan hubungi kontak di bawah ini! </p>
            </div>

            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto custom-scrollbar" style="max-height: calc(90vh - 180px);">
                <form id="detailedForm" class="space-y-8">
                    <!-- Additional Information -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-medium text-secondary">Kontak Whatsapp</h3>
                            <div class="flex-grow border-b border-gray-700/50"></div>
                        </div>
                        <x-alumni.settings-button
                        icon="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
                        href="https://wa.me/6281296143615?text=Ahlan,%20ana%20[Nama]%20dari%20[Angkatan],%20mengalami%20kendala%20dalam%20SiData"
                        title="Hubungi Admin"
                        subtitle=""
                        >
                      </x-alumni.settings-button>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-gray-700/50 bg-gray-900/50">
                <div class="flex justify-end space-x-4">
                    <button onclick="closeModal()" class="px-6 py-2 rounded-xl border border-gray-600 text-gray-400 hover:bg-gray-800 transition-all">
                        Tutup
                    </button>
                    {{-- <button onclick="submitForm()" class="px-6 py-2 bg-primary text-white rounded-xl hover:bg-primary/90 transition-all">
                        Submit
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('modalBackdrop').classList.remove('hidden');
            document.getElementById('modalBackdrop').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalBackdrop').classList.add('hidden');
            document.getElementById('modalBackdrop').classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('modalBackdrop').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>