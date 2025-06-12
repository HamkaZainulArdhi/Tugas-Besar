<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">{{ $jurnal->judul }}</h2>
                    
                    <!-- Journal Details -->
                    <div class="mb-6">
                        <p><strong>Penulis:</strong> {{ $jurnal->penulis }}</p>
                        <p><strong>Email:</strong> {{ $jurnal->email }}</p>
                        <p><strong>Kategori:</strong> {{ $jurnal->kategori }}</p>
                    </div>

                    <!-- Review Results -->
                    @if($hasilPenilaian->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-3">Hasil Review</h3>
                            @foreach($hasilPenilaian as $hasil)
                                <div class="border-b py-2">
                                    <p>
                                        <span class="font-medium">{{ $hasil->kategoriPenilaian->aspek }}:</span>
                                        <span class="{{ $hasil->is_accepted ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $hasil->is_accepted ? 'Diterima' : 'Ditolak' }}
                                        </span>
                                    </p>
                                    @if($hasil->catatan)
                                        <p class="text-gray-600 text-sm mt-1">{{ $hasil->catatan }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Upload Revision Button -->
                    @if(auth()->id() === $jurnal->user_id)
                        <div class="mt-4">
                            <button onclick="document.getElementById('uploadRevision').classList.remove('hidden')" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Upload Revisi
                            </button>
                        </div>

                        <!-- Upload Revision Form -->
                        <div id="uploadRevision" class="hidden mt-4">
                            <form action="{{ route('revisi.store', $jurnal->id) }}" 
                                method="POST" 
                                enctype="multipart/form-data"
                                  class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">File PDF Revisi</label>
                                    <input type="file" name="file_pdf" accept=".pdf" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Catatan Revisi</label>
                                    <textarea name="revision_notes" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                </div>
                                <button type="submit" 
                                        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                    Submit Revisi
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Revisions History -->
                    @if($jurnal->revisions->count() > 0)
                        <div class="mt-6">
                            <h3 class="text-xl font-bold mb-3">Riwayat Revisi</h3>
                            <div class="space-y-4">
                                @foreach($jurnal->revisions as $revision)
                                    <div class="border rounded-lg p-4">
                                        <p class="font-medium">Revisi #{{ $loop->iteration }}</p>
                                        <p class="text-sm text-gray-600">
                                            Diupload: {{ $revision->created_at->format('d M Y H:i') }}
                                        </p>
                                        @if($revision->revision_notes)
                                            <p class="mt-2 text-sm">{{ $revision->revision_notes }}</p>
                                        @endif
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $revision->file_pdf) }}" 
                                               target="_blank"
                                               class="text-blue-500 hover:underline">
                                                Lihat PDF
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>