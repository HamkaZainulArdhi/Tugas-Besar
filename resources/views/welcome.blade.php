<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Telkom Publisher') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .search-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class=" sticky top-0 z-10 bg-gray-100 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo/Brand -->
                <div class=" items-center">
                    <img src="{{ asset('logo.png') }}" alt="Logo" width="150" height="150" >
                </div>

                <!-- Navigation -->
                @if (Route::has('login'))
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-full text-gray-700 bg-white bg-opacity-20 hover:bg-opacity-30 transition-all duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-gray-800 hover:text-blue-500 transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="inline-flex items-center px-6 py-2.5 border border-white border-opacity-30 text-sm font-medium rounded-full text-gray-800 hover:text-blue-500  hover:bg-opacity-10 transition-all duration-200">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section 
    class="py-24 bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('telkom.jpg') }}');"
>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="bg-white/50 backdrop-blur-xs my-3 p-6 rounded-xl inline-block mx-auto">
                    <h2 class="text-4xl md:text-5xl font-bold text-blue-800 mb-4">
                        Temukan Jurnal Akademik Terbaik
                    </h2>
                    <p class="text-xl text-gray-700">
                        Akses koleksi jurnal ilmiah yang telah dikurasi dan disetujui oleh para ahli di berbagai bidang keilmuan.
                    </p>
                </div>
                

                <!-- Search and Filter Form -->
                <div class="max-w-4xl mx-auto">
                    <form method="GET" action="{{ route('welcome') }}" class="bg-white rounded-2xl p-6 shadow-2xl">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <!-- Search Input -->
                            <div class="md:col-span-2">
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Cari berdasarkan judul, penulis, atau abstrak..."
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <select name="kategori" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Cari Jurnal
                            </button>
                            @if(request('search') || request('kategori'))
                                <a href="{{ route('welcome') }}" 
                                   class="inline-flex items-center px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl transition-colors duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
   
</section>


    <!-- Statistics Section -->
    <section class="py-12 bg-white max-w-6xl mx-auto shadow-lg rounded-2xl my-8">
        <div class=" px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $jurnals->total() }}</div>
                    <div class="text-gray-600">Total Jurnal</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-600 mb-2">{{ $categories->count() }}</div>
                    <div class="text-gray-600">Kategori</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">{{ $jurnals->count() }}</div>
                    <div class="text-gray-600">Jurnal Terpilih</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Results Info -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">
                    @if(request('search') || request('kategori'))
                        Hasil Pencarian
                    @else
                        Jurnal Terbaru
                    @endif
                </h3>
                <p class="text-gray-600 mt-1">
                    Menampilkan {{ $jurnals->firstItem() ?? 0 }}-{{ $jurnals->lastItem() ?? 0 }} dari {{ $jurnals->total() }} jurnal
                </p>
            </div>
            
            @if(request('search'))
                <div class="text-sm text-gray-500">
                    Pencarian: "<span class="font-semibold">{{ request('search') }}</span>"
                </div>
            @endif
        </div>

        <!-- Jurnal Grid -->
        @if($jurnals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                @foreach($jurnals as $jurnal)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                        <!-- Card Header -->
                        <div class="p-6 pb-4">
                            <div class="flex items-start justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $jurnal->kategori }}
                                </span>
                                <div class="text-sm text-gray-500">
                                    {{ $jurnal->created_at->format('d M Y') }}
                                </div>
                            </div>

                            <h4 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight">
                                {{ $jurnal->judul }}
                            </h4>

                            <div class="flex items-center text-sm text-gray-600 mb-4">
                                <i class="fas fa-user mr-2"></i>
                                <span class="font-medium">{{ $jurnal->penulis }}</span>
                            </div>

                            <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                                {{ Str::limit($jurnal->abstrak, 150) }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 bg-gray-50 border-t">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-user-circle mr-2"></i>
                                    <span>{{ $jurnal->user->name ?? 'Anonymous' }}</span>
                                </div>
                                
                                <a href="{{ route('welcome.download', $jurnal->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-download mr-2"></i>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $jurnals->links('pagination::tailwind') }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="text-6xl text-gray-300 mb-6">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Tidak Ada Jurnal Ditemukan</h3>
                    <p class="text-gray-600 mb-8">
                        @if(request('search') || request('kategori'))
                            Coba ubah kata kunci pencarian atau filter kategori Anda.
                        @else
                            Belum ada jurnal yang tersedia saat ini.
                        @endif
                    </p>
                    @if(request('search') || request('kategori'))
                        <a href="{{ route('welcome') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-refresh mr-2"></i>
                            Lihat Semua Jurnal
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <img src="{{ asset('logo.png') }}" alt="Logo" width="150" height="150" >
                    <p class="text-gray-300 my-4 ">
                        Platform digital Dari Telkom University untuk mengakses koleksi jurnal ilmiah berkualitas tinggi dari berbagai bidang keilmuan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h6 class="font-semibold mb-4">Navigasi</h6>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Beranda</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Tentang</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="font-semibold mb-4">Bantuan</h6>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Panduan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-200">Dukungan</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} Telkom Publisher. All rights reserved by <a href="https://hamkasite.vercel.app/" class="text-gray-300 hover:text-white transition-colors duration-200">Kelompok 4</a>.
                </p>
            </div>
        </div>
    </footer>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>