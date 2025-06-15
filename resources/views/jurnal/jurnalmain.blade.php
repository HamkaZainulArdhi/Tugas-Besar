<x-app-layout>
    <div class="px-5 py-5 ">
      @php
          $user = Auth::user();
      @endphp
  
      @if($user && $user->usertype === 'admin')
      <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-book text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">
                        {{ __('Jurnal Management') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Kelola dan review jurnal akademik</p>
                </div>
            </div>
            
            @php $user = Auth::user(); @endphp
            @if($user && $user->usertype === 'admin')
                <div class="flex items-center space-x-4">
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/40 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">{{ count($jurnals) }} Jurnal</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        </x-slot>
    
        <div class="space-y-6">
            @php $user = Auth::user(); @endphp
    
            @if($user && $user->usertype === 'admin')
                <!-- Filter & Search Section -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/40 shadow-lg">
                    <form method="GET" action="{{ route('jurnal') }}" class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" 
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari jurnal..." 
                                    class="pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 w-64">
                            </div>
                            <select name="kategori" 
                                    onchange="this.form.submit()"
                                    class="w-full pr-9 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
    
                <!-- Journal Cards Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($jurnals as $jurnal)
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden">
                            <!-- Card Header -->
                            <div class="p-6 pb-4">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-2">
                                            @php
                                                $categoryColors = [
                                                    'scopus' => 'from-purple-500 to-pink-500',
                                                    'sinta 1' => 'from-emerald-500 to-teal-500',
                                                    'sinta 2' => 'from-blue-500 to-indigo-500',
                                                    'sinta 3' => 'from-amber-500 to-orange-500'
                                                ];
                                                $colorClass = $categoryColors[strtolower($jurnal->kategori)] ?? 'from-gray-500 to-gray-600';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-gradient-to-r {{ $colorClass }} shadow-sm">
                                                <i class="fa-solid fa-certificate mr-1"></i>
                                                {{ ucfirst($jurnal->kategori) }}
                                            </span>
                                        </div>
                                        <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                                            {{ $jurnal->judul }}
                                        </h3>
                                        <div class="flex items-center text-sm text-gray-600 mb-3">
                                            <i class="fa-solid fa-user mr-2"></i>
                                            <span class="font-medium">{{ $jurnal->penulis }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="w-12 h-12 bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl flex items-center justify-center group-hover:from-blue-100 group-hover:to-indigo-100 transition-all duration-200">
                                            <i class="fa-solid fa-file-pdf text-red-500 text-xl"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Abstract Preview -->
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                                        {{ Str::limit($jurnal->abstrak, 150) }}
                                    </p>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <i class="fa-solid fa-calendar mr-1"></i>
                                            {{ $jurnal->created_at->format('d M Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <i class="fa-solid fa-eye mr-1"></i>
                                            Review
                                        </span>
                                    </div>
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-6 pb-6">
                                <div class="flex space-x-3">
                                    <a href="{{ route('jurnalshow', ['filename' => $jurnal->file_pdf]) }}" 
                                    class="flex-1 flex items-center justify-center px-4 py-2.5 text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl group/btn">
                                        <i class="fa-solid fa-eye mr-2 group-hover/btn:scale-110 transition-transform duration-200"></i>
                                        <span class="font-medium">Review</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-12 bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-file-circle-question text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Tidak ada jurnal</h3>
                                <p class="mt-2 text-sm text-gray-500">Tidak ada jurnal yang sesuai dengan kriteria pencarian.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($jurnals->hasPages())
                    <div class="mt-6 g-gradient-to-r from-blue-500 to-indigo-600 p-4 rounded-xl text-center">
                        {{ $jurnals->links() }}
                    </div>
                @endif

    
            @elseif($user && $user->usertype === 'ini error')
            @else
            @endif

        @elseif($user && $user->usertype === 'user')
            <section class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-white">Upload Jurnal</h2>
                            <p class="text-blue-100 text-sm">Sistem Evaluasi Publisher Akademik</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <div class="space-y-8">
                        <!-- Judul Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Judul Jurnal
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="text" name="judul" id="judul" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white" 
                                placeholder="Masukkan judul jurnal" required>
                        </div>

                        <!-- Penulis Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Penulis
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="text" name="penulis" id="penulis" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white" 
                                placeholder="Nama penulis utama" required>
                        </div>

                        <!-- Kategori Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Kategori
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <select name="kategori" id="kategori" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white" 
                                required>
                                <option value="">Pilih Kategori Jurnal</option>
                                <option value="scopus">Scopus</option>
                                <option value="sinta 1">Sinta 1</option>
                                <option value="sinta 2">Sinta 2</option>
                                <option value="sinta 3">Sinta 3</option>
                            </select>
                        </div>

                        <!-- File Upload Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    File Jurnal (PDF)
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <input type="file" name="file_pdf" id="file_pdf" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white" 
                                accept=".pdf" required>
                        </div>

                        <!-- Abstrak Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    Abstrak
                                    <span class="text-red-500 ml-1">*</span>
                                </span>
                            </label>
                            <textarea name="abstrak" id="abstrak" rows="6" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white resize-none" 
                                placeholder="Tulis abstrak jurnal" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500/50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Submit Jurnal
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        @else
            <p class="text-center text-red-500 font-semibold">Silakan login terlebih dahulu.</p>
        @endif
        </div>
    </div>
</x-app-layout>
    @if(session('alert'))
    <x-alert 
        :type="session('alert.type')" 
        :title="session('alert.title')" 
        :message="session('alert.message')" 
    />
    @endif
  