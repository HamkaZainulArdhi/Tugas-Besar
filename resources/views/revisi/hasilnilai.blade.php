<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Hasil Penilaian Jurnal</h2>
                    </div>

                    @if(auth()->user()->usertype === 'admin')
                        <!-- Admin View - All Journals -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Jurnal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($jurnals as $index => $jurnal)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $jurnal->judul }}</div>
                                                <div class="text-sm text-gray-500">{{ $jurnal->kategori }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $jurnal->penulis }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Sudah Review
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('hasil.detail', $jurnal->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Belum ada jurnal yang dinilai
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @else
                        <!-- User View - Own Journals Results -->
                        @forelse($jurnals as $jurnal)
                            <div class="bg-white rounded-lg shadow p-6 mb-6">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $jurnal->judul }}</h3>
                                        <p class="text-sm text-gray-500">Penulis: {{ $jurnal->penulis }}</p>
                                    </div>
                                    
                                    <a href="{{ route('revisi.create', $jurnal->id) }}" 
                                      class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                       Upload Revisi
                                   </a>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aspek</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($jurnal->hasilPenilaian as $hasil)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4">{{ $hasil->kategoriPenilaian->aspek }}</td>
                                                    <td class="px-6 py-4">
                                                        @if($hasil->is_accepted)
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                Diterima
                                                            </span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                Perlu Revisi
                                                            </span>
                                                        @endif
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
                    
                                    <!-- Catatan section per jurnal -->
                                    @if($jurnal->hasilPenilaian->isNotEmpty() && $jurnal->hasilPenilaian->first()->catatan)
                                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Reviewer:</h4>
                                            <p class="text-sm text-gray-600">{{ $jurnal->hasilPenilaian->first()->catatan }}</p>
                                        </div>
                                    @endif
                    
                                    <!-- Revisions section per jurnal -->
                                    @if($jurnal->revisions->isNotEmpty())
                                        <div class="mt-6">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Riwayat Revisi:</h4>
                                            <div class="space-y-3">
                                                @foreach($jurnal->revisions as $revision)
                                                    <div class="p-3 bg-gray-50 rounded-lg">
                                                        <div class="flex justify-between items-center">
                                                            {{-- <p class="text-sm text-gray-600">
                                                                Diupload: {{ $revision->created_at->format('d M Y H:i') }}
                                                            </p> --}}
                                                            <a href="{{ asset('storage/' . $revision->file_pdf) }}" 
                                                               target="_blank"
                                                               class="text-blue-600 hover:text-blue-800 text-sm">
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
                            <!-- Upload Revision Modal for each journal -->
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Anda belum memiliki jurnal yang dinilai.
                            </div>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>