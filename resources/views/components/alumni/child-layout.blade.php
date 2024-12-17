<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alumni Portal</title>
    <!-- Dalam tag <head> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine Core -->
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    @livewireStyles
    @vite('resources/css/app.css')
    
    <link rel="stylesheet" href="{{ asset('css/alumni/style.css')}}" type="text/css">
    <script src="{{ asset('js/alumni/scripts.js')}}" defer></script>
    
    @stack('style')
</head>

<body class="antialiased min-h-screen font-[Plus Jakarta Sans]">
    <!-- Container Utama -->
    <div class="max-w-md mx-auto p-4">
        
        {{ $slot }}
    </div>
    @livewireScripts
    @include('sweetalert::alert')
    @stack('script')
</body>
</html>
