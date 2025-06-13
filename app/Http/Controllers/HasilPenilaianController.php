<?php

namespace App\Http\Controllers;

use App\Models\HasilPenilaian;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class HasilPenilaianController extends Controller
{
    public function index()
    {
        if (auth()->user()->usertype === 'admin') {
            $jurnals = Jurnal::whereHas('hasilPenilaian')
                ->with(['hasilPenilaian.kategoriPenilaian', 'hasilPenilaian.reviewer', 'user'])
                ->latest()
                ->get();
        } else {
            $jurnals = Jurnal::where('user_id', auth()->id())
                ->whereHas('hasilPenilaian')
                ->with(['hasilPenilaian.kategoriPenilaian', 'hasilPenilaian.reviewer'])
                ->latest()
                ->get();
        }

        return view('hasil-penilaian.index', compact('jurnals'));
    }

    public function edit($id)
    {
        $jurnal = Jurnal::with(['hasilPenilaian.kategoriPenilaian'])
            ->findOrFail($id);

        return view('hasil-penilaian.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hasil_penilaian.*.is_accepted' => 'required|boolean',
            'hasil_penilaian.*.catatan' => 'nullable|string'
        ]);

        $jurnal = Jurnal::findOrFail($id);

        foreach ($request->hasil_penilaian as $hasilId => $data) {
            HasilPenilaian::where('id', $hasilId)
                ->where('jurnal_id', $jurnal->id)
                ->update([
                    'is_accepted' => $data['is_accepted'],
                    'catatan' => $data['catatan']
                ]);
        }

        return redirect()->route('hasil-penilaian.index')
            ->with('success', 'Hasil penilaian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->hasilPenilaian()->delete();

        return redirect()->route('hasil-penilaian.index')
            ->with('success', 'Hasil penilaian berhasil dihapus');
    }
}