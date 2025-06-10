<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center space-x-4 ">
        <!-- Foto profil (huruf pertama nama) -->
        <img src="https://ui-avatars.com/api/?name={{ urlencode( $jurnals->penulis ?? 'User') }}&background=0D8ABC&color=fff"
             alt="Profile"
             class="w-10 h-10 rounded-full object-cover">
        <!-- Nama & Email -->
            <div>
              <p class="text-xs text-gray-600 dark:text-gray-400">
                Publisher Jurnal
             </p>
                <h2 class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $jurnals->penulis ?? 'Nama tidak tersedia' }}
                </h2>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    {{ $jurnals->user->email ?? 'Email tidak tersedia' }}
                </p>
            </div>
    </div>
</x-slot>

    <div class="max-w-full  ">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm">
        <div class="text-gray-900 dark:text-gray-100">
          
          <form action="{{ route('jurnal.store') }}" method="POST">
            @csrf
            
            <!-- Main Layout: PDF (Left) + Sidebar (Right) -->
            <div class="flex h-[625px]">
              
              <!-- PDF Preview Section (Takes most space - about 70%) -->
              <div class="flex-1 bg-gray-100 dark:bg-gray-900">
                <div class="h-full p-4">
                  @if($jurnals->file_pdf)
                    <embed
                      src="{{ asset('storage/' . $jurnals->file_pdf) }}"
                      type="application/pdf"
                      width="100%"
                      height="100%"
                      class="border border-gray-300 dark:border-gray-600 rounded-lg"
                    />
                  @else
                    <div class="h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                      <p class="text-gray-500 dark:text-gray-400">No PDF file available for this jurnal.</p>
                    </div>
                  @endif
                </div>
              </div>

              <!-- Sidebar Review Form (About 30% width) -->
              <div class="w-80  bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-600 flex flex-col">
                
                <!-- Sidebar Header -->
                <div class="p-4 border border-gray-200 dark:border-gray-600">
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Review Form</h3>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Periksa dan nilai jurnal</p>
                </div>

                <!-- Scrollable Content Area -->
                <div class="flex-1 overflow-y-auto">
                  
                  <!-- Checklist Section -->
                  <div class="p-4">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-3">Checklist Penilaian</h4>
                    <div class="space-y-2 max-h-full overflow-y-auto">
                      @foreach($checklistItems as $index => $item)
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3 bg-gray-50 dark:bg-gray-700">
                          <div class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                            <span class="font-medium">{{ $index + 1 }}.</span> {{ $item }}
                          </div>
                          <div class="flex gap-4">
                            <label class="flex items-center">
                              <input
                                type="checkbox"
                                name="checklist_accept[]"
                                value="{{ $index }}"
                                class="text-green-600 focus:ring-green-500 mr-2"
                                onchange="toggleExclusive(this)"
                                data-group="{{ $index }}"
                                data-type="accept"
                              >
                              <span class="text-sm text-green-600">Ceklist</span>
                            </label>
                            <label class="flex items-center">
                              <input
                                type="checkbox"
                                name="checklist_reject[]"
                                value="{{ $index }}"
                                class="text-red-600 focus:ring-red-500 mr-2"
                                onchange="toggleExclusive(this)"
                                data-group="{{ $index }}"
                                data-type="reject"
                              >
                              <span class="text-sm text-red-600">Tolak</span>
                            </label>
                          </div>
                          <script>
                            function toggleExclusive(current) {
                              const group = current.dataset.group;
                              const type = current.dataset.type;
                          
                              // Tentukan pasangan checkbox berdasarkan tipe
                              const otherType = type === 'accept' ? 'reject' : 'accept';
                          
                              // Cari checkbox lain dalam grup yang sama
                              const other = document.querySelector(
                                `input[data-group="${group}"][data-type="${otherType}"]`
                              );
                          
                              // Jika checkbox saat ini dicentang, uncheck yang lain
                              if (current.checked && other) {
                                other.checked = false;
                              }
                            }
                          </script>
                          
                        </div>
                      @endforeach
                    </div>
                  </div>

                  <!-- Notes Section -->
                  <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                    <label for="abstrak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                    <textarea 
                      id="abstrak" 
                      name="abstrak" 
                      rows="4" 
                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                      placeholder="Catatan, Saran atau Komentar"
                    ></textarea>
                  </div>

                <!-- Fixed Submit Buttons at Bottom -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">
                  <div class=" flex gap-2">
                    <button 
                      type="submit" 
                      name="action" 
                      value="approve"
                      class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                      Setujui Jurnal
                    </button>
                    
                    <button 
                      type="submit" 
                      name="action" 
                      value="reject"
                      class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200"
                    >
                      Tolak Jurnal
                    </button>
                  </div>
                </div>

              </div>
            </div>
            
          </form>
        </div>
      </div>
  </div>

  {{-- pdf js tampil --}}
  
</x-app-layout>