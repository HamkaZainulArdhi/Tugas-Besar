<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-clipboard-list text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">Hasil Penilaian Jurnal</h2>
                    <p class="text-sm text-gray-600 mt-1">Edit hasil review dan penilaian jurnal</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="bg-white/60 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/40 shadow-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">Status Review</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="min-h-screen ">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">Form Penilaian</h2>
                    <p class="text-blue-100 mt-1">Evaluasi setiap aspek dengan teliti dan berikan feedback yang konstruktif</p>
                </div>

                <form action="{{ route('hasil-penilaian.update', $jurnal->id) }}" method="POST" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($jurnal->hasilPenilaian as $index => $hasil)
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 hover:border-blue-300 transition-all duration-300 hover:shadow-lg">
                                    <!-- Header -->
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $hasil->kategoriPenilaian->aspek }}</h3>
                                            <p class="text-sm text-gray-500">Aspek Penilaian</p>
                                        </div>
                                    </div>
                        
                                    <!-- Select Status -->
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Penilaian</label>
                                    <select name="hasil_penilaian[{{ $hasil->id }}][is_accepted]"
                                            class="w-full px-4 py-2 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 font-medium">
                                        <option value="1" {{ $hasil->is_accepted ? 'selected' : '' }}>✅ Diterima</option>
                                        <option value="0" {{ !$hasil->is_accepted ? 'selected' : '' }}>⚠️ Perlu Revisi</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Shared Notes Section -->
                        <div class="space-y-3 mt-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Catatan & Feedback Umum
                            </label>
                            <div class="relative">
                                <textarea name="catatan" 
                                        rows="4" 
                                        placeholder="Berikan catatan umum untuk jurnal ini..."
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ $jurnal->hasilPenilaian->first()?->catatan }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>


                        <!-- Action Buttons -->
                        <div class="bg-gray-50 rounded-xl p-6 border-t-4 border-blue-500">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Pastikan semua penilaian telah diisi dengan benar sebelum menyimpan
                                </div>
                                <div class="flex gap-3">
                                    <button type="button" 
                                            onclick="window.history.back()"
                                            class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-all duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Additional Info Card -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-blue-900">Tips Penilaian</h3>
                        <div class="mt-2 text-sm text-blue-800">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Berikan feedback yang konstruktif dan spesifik</li>
                                <li>Status "Perlu Revisi" sebaiknya disertai dengan saran perbaikan yang jelas</li>
                                <li>Gunakan bahasa yang mendukung dan memotivasi untuk pengembangan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>