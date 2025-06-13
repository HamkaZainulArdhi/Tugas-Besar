@props(['jurnal'])

@if($jurnal->hasilPenilaian->isEmpty())
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
        Menunggu Review
    </span>
@elseif($jurnal->hasilPenilaian->contains('is_accepted', false))
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
        Perlu Revisi
    </span>
@else
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
        Diterima
    </span>
@endif