<x-app-layout>


  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section dengan Gradient -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-lg p-6 mb-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h3 class="text-2xl font-bold text-white mb-2">Aspek Penilaian</h3>
          <p class="text-blue-100">Kelola aspek penilaian untuk evaluasi yang komprehensif</p>
        </div>
        <div class="mt-4 sm:mt-0">
          <a href="{{ route('kategori.create') }}" 
             class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl shadow-lg hover:bg-gray-50 hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Aspek
          </a>
        </div>
      </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
      <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl shadow-sm">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
          </div>
        </div>
      </div>
    @endif

    <!-- Cards Grid -->
    @if(count($kategori) > 0)
      <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <!-- Table Header -->
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  No
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Aspek Penilaian
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Deskripsi
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Aksi
                </th>
              </tr>
            </thead>
            
            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($kategori as $item)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">{{ $loop->iteration }}</span>
                      </div>
                    </div>
                  </td>
                  
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div>
                        <div class="text-sm font-semibold text-gray-900">{{ $item->aspek }}</div>
                        <div class="text-xs text-gray-500">ID: #{{ $item->id }}</div>
                      </div>
                    </div>
                  </td>
                  
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-600 max-w-xs">
                      {{ $item->deskripsi ?: 'Tidak ada deskripsi tersedia' }}
                    </div>
                  </td>
                  
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                      <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></div>
                      Aktif
                    </span>
                  </td>
                  
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3">
                      <a href="{{ route('kategori.edit', $item) }}" 
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 bg-white rounded-md hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 text-xs font-medium">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                      </a>
                      
                      <form action="{{ route('kategori.destroy', $item) }}" method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus aspek {{ $item->aspek }}?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-1.5 border border-red-300 text-red-600 bg-white rounded-md hover:bg-red-50 hover:border-red-400 transition-colors duration-200 text-xs font-medium">
                          <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                          </svg>
                          Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @else
      <!-- Empty State -->
      <div class="bg-white rounded-lg border border-gray-200 p-12">
        <div class="text-center">
          <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-6">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada aspek penilaian</h3>
          <p class="text-gray-500 mb-8 max-w-sm mx-auto">Mulai dengan menambahkan aspek penilaian pertama untuk melakukan evaluasi.</p>
          <a href="{{ route('kategori.create') }}" 
            class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-medium rounded-md hover:bg-gray-800 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Aspek Pertama
          </a>
        </div>
      </div>
    @endif
  </div>


</x-app-layout>