<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased bg-[#020813] selection:bg-blue-500 selection:text-white overflow-x-hidden min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Abstract Background Glows -->
        <div class="absolute -top-1/4 -left-1/4 w-[60vw] h-[60vw] rounded-full bg-blue-600/10 blur-[150px] pointer-events-none"></div>
        <div class="absolute -bottom-1/4 -right-1/4 w-[60vw] h-[60vw] rounded-full bg-blue-900/20 blur-[150px] pointer-events-none"></div>
        <div class="absolute top-[30%] right-[10%] w-[35vw] h-[35vw] rounded-full bg-indigo-600/5 blur-[120px] pointer-events-none"></div>

        <!-- Inner wrapper -->
        <div class="w-full max-w-[450px] relative z-10">
            <!-- Glassmorphic Card Container -->
            <div class="w-full bg-[#030c20]/90 backdrop-blur-2xl border border-blue-500/20 shadow-[0_0_50px_rgba(30,58,138,0.3)] rounded-[2.5rem] px-8 py-10 sm:px-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
