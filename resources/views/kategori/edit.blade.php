<x-app-layout>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
      <!-- Header Section -->
 

      <!-- Main Form Card -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r  from-blue-600 to-purple-600 px-8 py-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
            </div>
            <div>
              <h2 class="text-xl font-semibold text-white">Form Penilaian Jurnal</h2>
              <p class="text-blue-100 text-sm">Sistem Evaluasi Publisher Akademik</p>
            </div>
          </div>
        </div>

        <form action="{{ route('kategori.update', $kategoriPenilaian) }}" method="POST" class="p-8">
          @csrf
          @method('PUT')
          
          <!-- Aspek Field -->
          <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Aspek Penilaian
              </span>
            </label>
            <div class="relative">
              <input 
                type="text" 
                name="aspek" 
                value="{{ old('aspek', $kategoriPenilaian->aspek) }}" 
                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white text-gray-800 placeholder-gray-400" 
                placeholder="Masukkan aspek yang akan dinilai..."
                required>
              <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
              </div>
            </div>
            @error('aspek') 
              <div class="mt-2 flex items-center text-red-600 text-sm">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
              </div> 
            @enderror
          </div>

          <!-- Deskripsi Field -->
          <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-3">
              <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                </svg>
                Deskripsi Detail
              </span>
            </label>
            <div class="relative">
              <textarea 
                name="deskripsi" 
                rows="6" 
                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-200 bg-gray-50 focus:bg-white text-gray-800 placeholder-gray-400 resize-none" 
                placeholder="Berikan penjelasan detail mengenai aspek penilaian ini...">{{ old('deskripsi', $kategoriPenilaian->deskripsi) }}</textarea>
              <div class="absolute top-4 right-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
              </div>
            </div>
            <div class="mt-2 text-xs text-gray-500">
              Tips: Jelaskan kriteria, standar, dan parameter yang akan digunakan dalam penilaian
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('kategori.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-gray-500/20">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-green-500/50">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
              </svg>
              Update Kategori
            </button>
          </div>
        </form>
      </div>

      <!-- Additional Info Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Konsistensi</h3>
          </div>
          <p class="text-gray-600 text-sm">Pastikan aspek penilaian konsisten dengan standar evaluasi jurnal</p>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Efisiensi</h3>
          </div>
          <p class="text-gray-600 text-sm">Gunakan deskripsi yang jelas dan mudah dipahami oleh reviewer</p>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
          <div class="flex items-center mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
              </svg>
            </div>
            <h3 class="font-semibold text-gray-800">Akademis</h3>
          </div>
          <p class="text-gray-600 text-sm">Sesuaikan dengan standar akademik dan praktik terbaik publisher</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>