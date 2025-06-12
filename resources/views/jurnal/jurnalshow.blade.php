<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center space-x-4">
      <img src="https://ui-avatars.com/api/?name={{ urlencode($jurnals->penulis ?? 'User') }}&background=0D8ABC&color=fff"
           alt="Profile"
           class="w-10 h-10 rounded-full object-cover">
      <div>
        <p class="text-xs text-gray-600 dark:text-gray-400">Publisher Jurnal</p>
        <h2 class="font-semibold text-sm text-gray-800 dark:text-gray-200 leading-tight">
          {{ $jurnals->penulis ?? 'Nama tidak tersedia' }}
        </h2>
        <p class="text-xs text-gray-600 dark:text-gray-400">
          {{ $jurnals->user->email ?? 'Email tidak tersedia' }}
        </p>
      </div>
    </div>
  </x-slot>

  <div class="max-w-full">
    <div class="bg-white dark:bg-gray-800 shadow-sm">
      <div class="text-gray-900 dark:text-gray-100">
        <form action="{{ route('jurnal.review.submit', $jurnals->id) }}" method="POST">
          @csrf

          <div class="flex h-[625px]">
            <!-- PDF Preview -->
            <div class="flex-1 bg-gray-100 dark:bg-gray-900 p-4">
              @if($jurnals->file_pdf)
                <embed src="{{ asset('storage/' . $jurnals->file_pdf) }}" type="application/pdf"
                       width="100%" height="100%"
                       class="border border-gray-300 dark:border-gray-600 rounded-lg" />
              @else
                <div class="h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600">
                  <p class="text-gray-500 dark:text-gray-400">No PDF file available for this jurnal.</p>
                </div>
              @endif
            </div>

            <!-- Sidebar Review -->
            <div class="w-80 border-l border-gray-200 dark:border-gray-600 flex flex-col bg-white dark:bg-gray-800">
              <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Review Form</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Periksa dan nilai jurnal</p>
              </div>

              <div class="flex-1 overflow-y-auto space-y-4 p-4">
                @foreach($checklistItems as $index => $item)
                  <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3 bg-gray-50 dark:bg-gray-700">
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                      {{ $index + 1 }}. {{ $item->aspek }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                      {{ $item->deskripsi }}
                    </div>
                    <div class="flex gap-4">
                      <label class="flex items-center">
                        <input type="checkbox" name="checklist_accept[]" value="{{ $item->id }}"
                               data-group="{{ $index }}" data-type="accept"
                               onchange="toggleExclusive(this)"
                               class="text-green-600 focus:ring-green-500 mr-2">
                        <span class="text-sm text-green-600">Ceklist</span>
                      </label>
                      <label class="flex items-center">
                        <input type="checkbox" name="checklist_reject[]" value="{{ $item->id }}"
                               data-group="{{ $index }}" data-type="reject"
                               onchange="toggleExclusive(this)"
                               class="text-red-600 focus:ring-red-500 mr-2">
                        <span class="text-sm text-red-600">Tolak</span>
                      </label>
                    </div>
                  </div>
                @endforeach
              </div>

              <div class="p-4 border-t border-gray-200 dark:border-gray-600">
                <label for="catatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catatan</label>
                <textarea id="catatan" name="catatan" rows="4"
                          class="w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                          placeholder="Catatan, Saran atau Komentar"></textarea>
              </div>

              <div class="p-4 border-t border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                  Kirim Penilaian
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS Exclusive Toggle -->
  <script>
    function toggleExclusive(current) {
      const group = current.dataset.group;
      const type = current.dataset.type;
      const otherType = type === 'accept' ? 'reject' : 'accept';
      const other = document.querySelector(
        `input[data-group="${group}"][data-type="${otherType}"]`
      );
      if (current.checked && other) {
        other.checked = false;
      }
    }
  </script>

  <!-- Error Alert -->
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="list-disc ml-5">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
</x-app-layout>
