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
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
       
        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        {{-- Flowbite --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', 'Figtree', sans-serif;
            }
        </style>
    </head>

    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-blue-50/30 to-indigo-50/30">
        <div class="flex h-screen overflow-hidden">
            
            {{-- Sidebar dengan lebar yang disesuaikan --}}
            @unless(Route::is('jurnalshow'))
                <div class="w-80 flex-shrink-0 hidden sm:block">
                    @include('layouts.sidebar')
                </div>
            @endunless
        
            {{-- Konten utama di samping sidebar --}}
            <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
                
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 shadow-sm px-6 py-4 flex-shrink-0">
                        <div class="max-w-none">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
    
                {{-- Main content area with proper scrolling --}}
                <main class="flex-1 overflow-y-auto bg-gradient-to-br from-white/50 to-gray-50/80 p-6">
                    <div class="max-w-none">
                        {{ $slot }}
                    </div>
                </main>
            </div>
    
        </div>

        {{-- Mobile overlay untuk sidebar --}}
        @unless(Route::is('jurnalshow'))
            <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden sm:hidden" onclick="toggleSidebar()"></div>
        @endunless

        <script>
            // JavaScript untuk toggle sidebar di mobile
            function toggleSidebar() {
                const sidebar = document.getElementById('default-sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (sidebar && overlay) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }
            }

            // Event listener untuk tombol toggle
            document.addEventListener('DOMContentLoaded', function() {
                const toggleButton = document.querySelector('[data-drawer-toggle="default-sidebar"]');
                if (toggleButton) {
                    toggleButton.addEventListener('click', toggleSidebar);
                }
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('default-sidebar');
                const toggleButton = document.querySelector('[data-drawer-toggle="default-sidebar"]');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (sidebar && !sidebar.contains(event.target) && 
                    toggleButton && !toggleButton.contains(event.target) && 
                    window.innerWidth < 640) {
                    sidebar.classList.add('-translate-x-full');
                    if (overlay) overlay.classList.add('hidden');
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>