<!-- Tambahkan ini di layout utama kalau belum -->
<script src="https://unpkg.com/alpinejs" defer></script>

<!-- Alert -->
<div 
  x-data="{ show: true }" 
  x-show="show"
  x-transition:enter="transform ease-out duration-500 transition"
  x-transition:enter-start="-translate-y-full opacity-0"
  x-transition:enter-end="translate-y-0 opacity-100"
  x-transition:leave="transform ease-in duration-500 transition"
  x-transition:leave-start="translate-y-0 opacity-100"
  x-transition:leave-end="-translate-y-full opacity-0"
  x-init="setTimeout(() => show = false, 4000)" 
  class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-lg"
  role="alert"
>
  <div class="border-s-4 border-red-700 bg-red-50 p-4 rounded shadow">
    <div class="flex items-center gap-2 text-red-700">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-5" viewBox="0 0 24 24">
        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
      </svg>
      <strong class="font-medium"> Something went wrong </strong>
    </div>

    <p class="mt-2 text-sm text-red-700">
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo quasi assumenda numquam deserunt
      consectetur autem nihil quos debitis dolor culpa.
    </p>
  </div>
</div>
