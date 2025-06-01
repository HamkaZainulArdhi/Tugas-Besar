<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
        <div class="flex h-screen ">
            
            {{-- Sidebar dengan lebar tetap --}}
            <div class="w-64 bg-white dark:bg-gray-800">
                @include('layouts.sidebar')
            </div>
    
            {{-- Konten utama di samping sidebar --}}
            <div class="flex flex-col flex-1">
                
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow px-6 py-4 bo">
                        <div class="max-w-7xl mx-auto">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
    
                <main class="flex-1  ">
                    {{ $slot }}
                </main>
            </div>
    
        </div>
    </body>
    
    

</html>