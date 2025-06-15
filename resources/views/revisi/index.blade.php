{{-- // ini halaman buat admin liat hasil jurnal yg di upload ulang --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-file-pen text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">Revisi Jurnal</h2>
                    <p class="text-sm text-gray-600 mt-1">Catatan dan unggahan ulang jurnal hasil revisi</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-violet-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white">Daftar Revisi Pertama</h2>
                    <p class="text-pink-100 mt-1">Menampilkan catatan dan file revisi pertama dari jurnal</p>
                </div>

                <div class="p-8 space-y-6">
                    @php
                        $firstRevision = $jurnal->revisions->first();
                    @endphp

                    @if($firstRevision)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $firstRevision->journal->judul }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Direvisi oleh: {{ $firstRevision->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $firstRevision->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <a href="{{ asset('storage/' . $firstRevision->file_pdf) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200 shadow">
                                    <i class="fa-solid fa-file-pdf mr-2"></i> Lihat PDF
                                </a>
                            </div>

                            @if($firstRevision->revision_notes)
                                <div class="mt-5 p-4 bg-white border-l-4 border-blue-600 rounded-md shadow-sm">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-2 flex items-center">
                                        <i class="fa-solid fa-comment-dots mr-2 text-blue-500"></i> Catatan Revisi
                                    </h4>
                                    <p class="text-sm text-gray-700 leading-relaxed">
                                        {{ $firstRevision->revision_notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12 text-sm text-gray-500">
                            <i class="fa-solid fa-circle-info text-gray-400 text-2xl mb-3"></i><br>
                            Belum ada revisi jurnal yang diunggah.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
