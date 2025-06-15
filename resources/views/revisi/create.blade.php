<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-violet-600 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $jurnal->judul }}</h1>
                    <div class="flex items-center space-x-6 text-blue-100">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ $jurnal->penulis }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <span>{{ $jurnal->email }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium">{{ $jurnal->kategori }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Review Results -->
                    @if($hasilPenilaian->count() > 0)
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900">Hasil Review</h2>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="space-y-6">
                                    @foreach($hasilPenilaian as $hasil)
                                        <div class="group hover:bg-gray-50/50 rounded-xl p-4 transition-all duration-200">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $hasil->kategoriPenilaian->aspek }}</h3>
                                                    @if($hasil->catatan)
                                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $hasil->catatan }}</p>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    @if($hasil->is_accepted)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Diterima
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Ditolak
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Revisions History -->
                    @if($jurnal->revisions->count() > 0)
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900">Riwayat Revisi</h2>
                                </div>
                            </div>
                            <div class="p-8">
                                <div class="space-y-6">
                                    @foreach($jurnal->revisions as $revision)
                                        <div class="group hover:bg-gray-50/50 rounded-xl p-6 border border-gray-100 transition-all duration-200">
                                            <div class="flex items-start justify-between mb-4">
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 mb-1">Revisi #{{ $loop->iteration }}</h3>
                                                    <p class="text-sm text-gray-500 flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $revision->created_at->format('d M Y H:i') }}
                                                    </p>
                                                </div>
                                                <a href="{{ asset('storage/' . $revision->file_pdf) }}" 
                                                   target="_blank"
                                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Lihat PDF
                                                </a>
                                            </div>
                                            @if($revision->revision_notes)
                                                <div class="bg-gray-50 rounded-lg p-4">
                                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $revision->revision_notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    @if(auth()->id() === $jurnal->user_id)
                        <!-- Upload Revision Card -->
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden sticky top-8">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-900">Upload Revisi</h3>
                            </div>
                            <div class="p-6">
                                <button onclick="document.getElementById('uploadRevision').classList.toggle('hidden')" 
                                        class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl font-medium hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Upload Revisi</span>
                                </button>

                                <!-- Upload Revision Form -->
                                <div id="uploadRevision" class="hidden mt-6 space-y-6">
                                    <form action="{{ route('revisi.store', $jurnal->id) }}" 
                                        method="POST" 
                                        enctype="multipart/form-data"
                                        class="space-y-6">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">File PDF Revisi</label>
                                            <div class="relative">
                                                <input type="file" name="file_pdf" accept=".pdf" required
                                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Revisi</label>
                                            <textarea name="revision_notes" rows="4" placeholder="Tambahkan catatan untuk revisi ini..."
                                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                                        </div>
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white px-6 py-3 rounded-xl font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>Submit Revisi</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>