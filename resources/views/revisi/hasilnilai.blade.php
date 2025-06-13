<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-file-pen text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">
                        {{ __('Hasil Penilaian Jurnal') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Pantau hasil review dan penilaian jurnal</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="bg-white/60 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/40 shadow-sm">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-gray-700">{{ $jurnals->count() }} Jurnal Dinilai</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->usertype === 'admin')
                <!-- Admin View -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg overflow-hidden">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Jurnal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($jurnals as $index => $jurnal)
                                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="w-8 h-8 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">{{ $index + 1 }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $jurnal->judul }}</div>
                                                <div class="text-xs text-gray-500">{{ $jurnal->kategori }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jurnal->penulis }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 text-xs rounded-full font-medium bg-green-100 text-green-800">
                                                    Revisi Dikirim
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('hasil.detail', $jurnal->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                                    <i class="fa-solid fa-eye mr-2"></i>
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                Belum ada jurnal yang dinilai
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <!-- User View -->
                @forelse($jurnals as $jurnal)
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg mb-6">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $jurnal->judul }}</h3>
                                    <p class="text-sm text-gray-500">Penulis: {{ $jurnal->penulis }}</p>
                                </div>
                                
                                <a href="{{ route('revisi.create', $jurnal->id) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg text-sm font-medium">
                                    <i class="fa-solid fa-upload mr-2"></i>
                                    Upload Revisi
                                </a>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50/50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aspek</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jurnal->hasilPenilaian as $hasil)
                                            <tr class="hover:bg-gray-50/50">
                                                <td class="px-6 py-4">{{ $hasil->kategoriPenilaian->aspek }}</td>
                                                <td class="px-6 py-4">
                                                    <span class="px-3 py-1 text-xs rounded-full font-medium
                                                        {{ $hasil->is_accepted ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $hasil->is_accepted ? 'Diterima' : 'Perlu Revisi' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                                    Belum ada hasil penilaian
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- Reviewer Notes -->
                                @if($jurnal->hasilPenilaian->isNotEmpty() && $jurnal->hasilPenilaian->first()->catatan)
                                    <div class="mt-6 p-4 bg-gray-50/50 rounded-xl">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Reviewer:</h4>
                                        <p class="text-sm text-gray-600">{{ $jurnal->hasilPenilaian->first()->catatan }}</p>
                                    </div>
                                @endif

                                <!-- Revision History -->
                                @if($jurnal->revisions->isNotEmpty())
                                    <div class="mt-6">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Riwayat Revisi:</h4>
                                        <div class="space-y-3">
                                            @foreach($jurnal->revisions as $revision)
                                                <div class="p-4 bg-gray-50/50 rounded-xl">
                                                    <div class="flex justify-between items-center">
                                                        <a href="{{ asset('storage/' . $revision->file_pdf) }}" 
                                                           target="_blank"
                                                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                            <i class="fa-solid fa-file-pdf mr-2"></i>
                                                            Lihat PDF
                                                        </a>
                                                    </div>
                                                    @if($revision->revision_notes)
                                                        <p class="text-sm text-gray-500 mt-2">{{ $revision->revision_notes }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white/80 backdrop-blur-sm rounded-2xl border border-white/40 shadow-lg">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-file-circle-question text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum ada jurnal</h3>
                        <p class="mt-2 text-sm text-gray-500">Anda belum memiliki jurnal yang dinilai.</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</x-app-layout>