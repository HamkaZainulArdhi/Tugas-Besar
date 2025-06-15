<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriPenilaian;

class KategoriNilai extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategori = KategoriPenilaian::all();
        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    // Tambah kategori baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'aspek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriPenilaian::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori penilaian berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = KategoriPenilaian::findOrFail($id);

        $validated = $request->validate([
            'aspek' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori penilaian berhasil diperbarui',
            'data' => $kategori
        ]);
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = KategoriPenilaian::findOrFail($id);
        $kategori->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kategori penilaian berhasil dihapus'
        ]);
    }
}



