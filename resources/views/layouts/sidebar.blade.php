<!-- Mobile Toggle Button - Positioned in header area -->
<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="fixed top-4 left-4 z-50 inline-flex items-center p-3 text-sm text-gray-600 rounded-xl sm:hidden hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200 shadow-lg border border-gray-200 bg-white/80 backdrop-blur-sm">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<!-- Sidebar -->
<aside id="default-sidebar" class="fixed sm:relative top-0 left-0 z-40 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-6 py-8 overflow-y-auto bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 border-r border-gray-200/50 flex flex-col shadow-xl">
        
        <!-- Header Brand -->
        <div class="mb-8">
            <div class=" items-center space-x-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="200" height="200" >
            </div>
        </div>

        <!-- Profile Section -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/20 relative overflow-hidden">
                <!-- Decorative gradient -->
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-200/30 to-indigo-200/30 rounded-full -translate-y-4 translate-x-4"></div>
                
                <div class="relative">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="relative">
                            <img 
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&size=64" 
                                alt="Profile" 
                                class="w-16 h-16 rounded-2xl object-cover shadow-md ring-4 ring-white"
                            />
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                <i class="fa-solid fa-star mr-1"></i>
                                {{ Auth::user()->usertype}}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('profile.edit') }}" class="flex-1 flex items-center justify-center px-3 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 group">
                            <i class="fa-solid fa-gear mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                            Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center px-3 py-2.5 text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 group">
                                <i class="fa-solid fa-right-from-bracket mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 space-y-1">
            <!-- Dashboard -->
            @auth
                @if (auth()->user()->usertype === 'admin')
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-house w-5 h-3 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                    <span class="ml-3">{{ __('Dashboard') }}</span>
                </div>
            </x-nav-link>
                @else
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-house w-5 h-3 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                        <span class="ml-3">{{ __('Dashboard') }}</span>
                    </div>
                </x-nav-link>
                @endif
            @endauth
        
            <!-- Jurnal -->
            <x-nav-link :href="route('jurnal')" :active="request()->routeIs('jurnal')" 
                class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('jurnal') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-book w-5 h-3 {{ request()->routeIs('jurnal') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                    <span class="ml-3">{{ __('Jurnal') }}</span>
                </div>
            </x-nav-link>

            <!-- Kategori Penilaian -->
            @auth
            {{-- Untuk Admin --}}
            @if (auth()->user()->usertype === 'admin')
                <!-- Kategori Penilaian -->
                <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('kategori.*') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-list-check w-5 h-3 {{ request()->routeIs('kategori.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                        <span class="ml-3">{{ __('Kategori Penilaian') }}</span>
                    </div>
                </x-nav-link>

                <x-nav-link :href="route('hasil-penilaian.index')" :active="request()->routeIs('hasil-penilaian.*')" 
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('hasil-penilaian.*') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                    <div class="flex items-center">
                        <i class="fa-solid fa-clipboard-check w-5 h-3 {{ request()->routeIs('hasil-penilaian.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                        <span class="ml-3">{{ __('Hasil Penilaian') }}</span>
                    </div>
                </x-nav-link>
            @endif
            @endauth

            <x-nav-link :href="route('hasil.nilai')" :active="request()->routeIs('hasil.*')" 
                class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-300 group {{ request()->routeIs('hasil.*') ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-500' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-500' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-file-pen w-5 h-3 {{ request()->routeIs('hasil.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-100' }} transition-colors duration-200"></i>
                    <span class="ml-3">{{ __('Revisi') }}</span>
                </div>
            </x-nav-link>

        </nav>  

        <!-- Footer -->
        <div class="mt-auto pt-6 border-t border-gray-200/50">
            <div class="text-center">
                <p class="text-xs text-gray-500">Tugas Besar</p>
                <p class="text-xs text-gray-400 mt-1">PAW-2025      </p>
            </div>
        </div>
    </div>
</aside>