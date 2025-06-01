<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class JurnalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'kategori' => 'nullable|string',
            'abstrak' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('jurnals', 'public');
        }

        Jurnal::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kategori' => $request->kategori,
            'abstrak' => $request->abstrak,
            'file_pdf' => $filePath,
            
            
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Jurnal berhasil ditambahkan.');
    }
    public function index()
{
    $jurnals = Jurnal::latest()->get(); // Ambil semua data jurnal
    return view('jurnal.jurnalmain', compact('jurnals')); // Kirim ke view
}
}
