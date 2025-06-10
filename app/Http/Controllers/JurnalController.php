<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


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

        $user = Auth::user();
        $user->jurnals()->create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'email' => $user->email,
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

    public function showByFilename ($filename) 
    {
        // dd($filename);
        $jurnals = Jurnal::with('user')->where('file_pdf', $filename)->firstOrFail();

        

        $checklistItems = [
            'Termasuk ke dalam salah satu tema PKM TEMATIK 2025 (DITANYA MASUK KE TEMA BERAPA)',
            'Judul PKM tidak boleh menggunakan akronim atau singkatan...',
            'Tipe huruf menggunakan Times New Roman ukuran 12',
            'Daftar Pustaka harvard style, font size 12, TNR, URUT ABJAD, Tidak boleh ada et al.',
            'Tata letak menggunakan ukuran kertas A-4, satu kolom, margin kiri 4 cm, margin kanan, atas, dan bawah masing-masing 3 cm'
            
        ];
    
        return view('jurnal.jurnalshow', compact('jurnals', 'checklistItems'));
    }



}
