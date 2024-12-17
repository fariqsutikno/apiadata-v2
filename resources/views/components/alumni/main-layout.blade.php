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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/alumni/style.css')}}">
    <script src="{{ asset('js/alumni/scripts.js')}}"></script>
    @livewireStyles

    <!-- Alpine.js for handling tabs and interactions -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('style')
</head>

<body class="antialiased min-h-screen font-sans">
    <!-- Container Utama -->
    <div class="max-w-md mx-auto p-4">
        
        {{ $slot }}

        <!-- Empty div for spacing -->
        <div class="h-16"></div> <!-- Adjust the height as needed -->
        <x-alumni.navbar></x-alumni.navbar>
        
    </div>
    @livewireScripts
    @include('sweetalert::alert')
    @stack('script')
</body>
</html>
