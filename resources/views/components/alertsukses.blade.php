<!-- Tambahkan ini di layout utama jika belum ada -->
<script src="https://unpkg.com/alpinejs" defer></script>

<!-- Alert -->
<div
  x-data="{ show: true }"
  x-show="show"
  x-transition:enter="transition transform ease-out duration-500"
  x-transition:enter-start="-translate-y-100 opacity-0"
  x-transition:enter-end="translate-y-0 opacity-100"
  x-transition:leave="transition transform ease-in duration-500"
  x-transition:leave-start="translate-y-0 opacity-100"
  x-transition:leave-end="-translate-y-10 opacity-0"
  class="fixed top-5 left-1/2 z-50 w-full max-w-md -translate-x-1/2"
  role="alert"
>
  <div class="rounded-md border border-gray-300 bg-white p-4 shadow-md dark:border-gray-600 dark:bg-gray-800">
    <div class="flex items-start gap-4">
      <!-- Icon -->
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="size-6 text-green-600"
      >
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>

      <!-- Content -->
      <div class="flex-1">
        <strong class="font-medium text-gray-900 dark:text-white">Berhasil</strong>
        <p class="mt-0.5 text-sm text-gray-700 dark:text-gray-200">
          Jurnal berhasil diunggah.
        </p>
      </div>

      <!-- Close -->
      <button
        @click="show = false"
        class="-m-2 rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>
</div>
