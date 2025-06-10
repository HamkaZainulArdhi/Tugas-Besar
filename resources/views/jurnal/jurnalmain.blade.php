<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jurnal') }}
        </h2>
    </x-slot>
  
    <div class="px-5 ">
      @php
          $user = Auth::user();
      @endphp
  
      @if($user && $user->usertype === 'admin')
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Judul</th>
                    <th scope="col" class="px-6 py-3">Penulis</th>
                    <th scope="col" class="px-6 py-3">Skema</th>
                    <th scope="col" class="px-6 py-3">Abstrak</th>
                    <th scope="col" class="px-6 py-3">Review</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jurnals as $jurnal)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $jurnal->judul }}
                    </th>
                    <td class="px-6 py-4">{{ $jurnal->penulis }}</td>
                    <td class="px-6 py-4">{{ $jurnal->kategori }}</td>
                    <td class="px-6 py-4 text-justify break-words whitespace-normal max-w-xs">
                        {{ Str::limit($jurnal->abstrak, 200) }}
                    </td>
                    <td class="px-6 py-4 text-left">
                        <a href="{{ route('jurnalshow', $jurnal->file_pdf) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            Review
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  
      @elseif($user && $user->usertype === 'user')
      <section class="bg-white dark:bg-gray-900 ">
        <div class="py-6 px-4 max-w-7xl">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Upload jurnal</h2>
            <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Jurnal</label>
                        <input type="text" name="judul" id="judul" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tulis Judul Jurnal" required="">
                    </div>
                    <div class="w-full">
                        <label for="panulis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Penulis Utama" required="">
                    </div>
                    <div>
                        <label for="kategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                        <select id="kategori" name="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option selected="">Pilih Kategori Jurnal</option>
                            <option value="scopus">Scopus</option>
                            <option value="sinta 1">Sinta 1</option>
                            <option value="sinta 2">Sinta 2</option>
                            <option value="sinta 3">Sinta 3</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="file_pdf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File Jurnal</label>
                        <input id="file_pdf" name="file_pdf" type="file" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Your description here"></input>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="abstrak" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Abstrak</label>
                        <textarea id="abstrak" name="abstrak" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tulis abstrak"></textarea>
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 
                py-2.5 mt-4 sm:mt-6 text-sm font-medium text-
                 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 
                 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Sumbit Jurnal
                </button>
            </form>
        </div>
      </section>

            @if (session('success'))
                @include('components.alertsukses', ['message' => session('success')])
            @endif

            @if (session('error'))
                @include('components.alertgagal', ['message' => session('error')])
            @endif
  
      @else
          <p class="text-center text-red-500 font-semibold">Silakan login terlebih dahulu.</p>
      @endif
    </div>
  </x-app-layout>
  