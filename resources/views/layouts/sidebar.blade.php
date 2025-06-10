<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
  <span class="sr-only">Open sidebar</span>
  <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
     <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
  </svg>
</button>

<aside id="default-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidenav">
    <div class="overflow-y-auto py-7 px-3 h-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700 flex flex-col">
        {{-- Bagian Atas: Profil --}}
        <div class="flex flex-col items-center text-center px-4 border-">
            <img 
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                alt="Profile"
                class="w-20 h-20 rounded-full object-cover mb-3"
            />
            <h2 class="text-lg font-bold text-white dark:text-white">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-gray-300">{{ Auth::user()->email }}</p>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="w-full mt-4">
                @csrf
                <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-white border border-gray-500 rounded hover:bg-gray-700 transition">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                </button>
            </form>

            {{-- Tombol Setting Profil (ikon gear) --}}
            <a href="{{ route('profile.edit') }}" class="mt-3 text-gray-300 hover:text-white transition">
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-700 hover:bg-gray-600">
                    <i class="fa-solid fa-gear"></i>
                </div>
            </a>
        </div>

        {{-- Navigasi --}}
        <div class="mt-8 flex flex-col space-y-2 ">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-house mr-2 text-base"></i>
                {{ __('Dashboard') }}
            </x-nav-link>
        
            <x-nav-link :href="route('jurnal')" :active="request()->routeIs('jurnal')">
                <i class="fa-solid fa-book mr-2 text-base"></i>
                {{ __('Jurnal') }}
            </x-nav-link>
        </div>

    </div>
</aside>

