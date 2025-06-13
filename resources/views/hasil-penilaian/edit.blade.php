<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Edit Hasil Penilaian</h2>
                        <a href="{{ route('hasil-penilaian.index') }}" 
                           class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Kembali
                        </a>
                    </div>

                    <form action="{{ route('hasil-penilaian.update', $jurnal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            @foreach($jurnal->hasilPenilaian as $hasil)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-medium mb-4">
                                        {{ $hasil->kategoriPenilaian->aspek }}
                                    </h4>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Status
                                            </label>
                                            <select name="hasil_penilaian[{{ $hasil->id }}][is_accepted]" 
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <option value="1" {{ $hasil->is_accepted ? 'selected' : '' }}>
                                                    Diterima
                                                </option>
                                                <option value="0" {{ !$hasil->is_accepted ? 'selected' : '' }}>
                                                    Perlu Revisi
                                                </option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                Catatan
                                            </label>
                                            <textarea name="hasil_penilaian[{{ $hasil->id }}][catatan]" 
                                                      rows="3" 
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $hasil->catatan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="flex justify-end pt-6">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>