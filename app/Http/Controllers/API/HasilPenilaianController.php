<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilPenilaian;

class HasilPenilaianController extends Controller
{
    public function index()
    {
        $data = HasilPenilaian::with(['jurnal', 'kategoriPenilaian', 'reviewer'])->get();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurnal_id' => 'required|exists:jurnals,id',
            'kategori_penilaian_id' => 'required|exists:kategori_penilaians,id',
            'reviewer_id' => 'required|exists:users,id',
            'is_accepted' => 'required|boolean',
            'catatan' => 'nullable|string',
        ]);

        $hasil = HasilPenilaian::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Hasil penilaian berhasil ditambahkan',
            'data' => $hasil
        ], 201);
    }
}
