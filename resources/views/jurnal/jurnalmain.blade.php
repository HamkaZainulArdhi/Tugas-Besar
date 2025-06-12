<x-app-layout>
    <div class="px-5 py-5 ">
      @php
          $user = Auth::user();
      @endphp
  
      @if($user && $user->usertype === 'admin')
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Judul</th>
                    <th scope="col" class="px-6 py-3">Penulis</th>
                    <th scope="col" class="px-6 py-3">Skema</th>
                    <th scope="col" class="px-6 py-3">Abstrak</th>
                    <th scope="col" class="px-6 py-3">Review</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jurnals as $jurnal)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $jurnal->judul }}
                    </th>
                    <td class="px-6 py-4">{{ $jurnal->penulis }}</td>
                    <td class="px-6 py-4">{{ $jurnal->kategori }}</td>
                    <td class="px-6 py-4 text-justify break-words whitespace-normal max-w-xs">
                        {{ Str::limit($jurnal->abstrak, 200) }}
                    </td>
                    <td class="px-6 py-4 text-left">
                        <a href="{{ route('jurnalshow', ['filename' => $jurnal->file_pdf]) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Review
                        </a>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  
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
</x-app-layout>
@if(session('alert'))
<x-alert 
    :type="session('alert.type')" 
    :title="session('alert.title')" 
    :message="session('alert.message')" 
/>
@endif
  