<x-app-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6">
                  <h2 class="text-2xl font-bold mb-6">Daftar Revisi Jurnal</h2>
                  
                  <div class="space-y-4">
                    @forelse($jurnal->revisions as $revision)
                          <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                              <div class="flex justify-between items-start">
                                  <div>
                                      <h3 class="font-semibold text-lg">{{ $revision->journal->judul }}</h3>
                                      <p class="text-sm text-gray-600">Direvisi oleh: {{ $revision->user->name }}</p>
                                      <p class="text-sm text-gray-500">{{ $revision->created_at->format('d M Y H:i') }}</p>
                                  </div>
                                  <a href="{{ asset('storage/' . $revision->file_pdf) }}" 
                                     target="_blank"
                                     class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 text-sm">
                                      Lihat PDF
                                  </a>
                              </div>
                              @if($revision->revision_notes)
                                  <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                      <p class="text-sm text-gray-600">{{ $revision->revision_notes }}</p>
                                  </div>
                              @endif
                          </div>
                      @empty
                          <div class="text-center py-8 text-gray-500">
                              Belum ada revisi jurnal yang diupload.
                          </div>
                      @endforelse
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>