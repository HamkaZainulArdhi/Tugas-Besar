<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between  ">
            <div class="flex items-center space-x-4 ">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-clipboard-check text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">
                        {{ __('Penilaian Jurnal') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Kelola penilaian jurnal akademik</p>
                </div>
            </div>
            
            @if(auth()->user()->usertype === 'admin')
                <div class="flex items-center space-x-4">
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/40 shadow-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-gray-700">{{ $jurnals->count() }} Total Penilaian</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-xl shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Jurnal</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reviewer</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jurnals as $index => $jurnal)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ $index + 1 }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $jurnal->judul }}</div>
                                    <div class="text-xs text-gray-500">{{ $jurnal->kategori }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $jurnal->hasilPenilaian->contains('is_accepted', false) 
                                            ? 'bg-yellow-100 text-yellow-800' 
                                            : 'bg-green-100 text-green-800' }}">
                                        <div class="w-1.5 h-1.5 
                                            {{ $jurnal->hasilPenilaian->contains('is_accepted', false) 
                                                ? 'bg-yellow-400' 
                                                : 'bg-green-400' }} 
                                            rounded-full mr-1.5"></div>
                                        {{ $jurnal->hasilPenilaian->contains('is_accepted', false) ? 'Perlu Revisi' : 'Diterima' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jurnal->hasilPenilaian->first()->reviewer->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('hasil-penilaian.edit', $jurnal->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-gray-700 bg-white rounded-md hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 text-xs font-medium">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada penilaian jurnal
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>