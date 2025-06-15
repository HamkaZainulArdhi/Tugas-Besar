<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;

class APIjurnal extends Controller
{
     // ✅ Ambil semua jurnal
    // Read: Ambil semua jurnal
    public function index()
    {
        $jurnals = Jurnal::with('user')->get(); // opsional: relasi user
        return response()->json([
            'status' => 'success',
            'data' => $jurnals
        ]);
    }

    // Create: Simpan jurnal baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'email' => 'required|email',
            'kategori' => 'nullable|string',
            'abstrak' => 'required|string',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('jurnals', 'public');
        }

        $jurnal = Jurnal::create([
            'user_id' => $request->user()->id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'email' => $request->email,
            'kategori' => $request->kategori,
            'abstrak' => $request->abstrak,
            'file_pdf' => $filePath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Jurnal berhasil ditambahkan',
            'data' => $jurnal
        ], 201);
    }
}
