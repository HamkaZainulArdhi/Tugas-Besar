<?php

namespace App\Http\Controllers;
use App\Models\KategoriPenilaian;

use Illuminate\Http\Request;

class KategoriPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriPenilaian::all();
        return view('kategori.index', compact('kategori'));
    }
    
    public function create()
    {
        return view('kategori.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'aspek' => 'required',
            'deskripsi' => 'nullable',
        ]);
    
        KategoriPenilaian::create($request->only('aspek', 'deskripsi'));
    
        return redirect()->route('kategori.index')->with('success', 'Kategori ditambahkan');
    }
    
    public function edit(KategoriPenilaian $kategoriPenilaian)
    {
        return view('kategori.edit', compact('kategoriPenilaian'));
    }
    
    public function update(Request $request, KategoriPenilaian $kategoriPenilaian)
    {
        $request->validate([
            'aspek' => 'required',
            'deskripsi' => 'nullable',
        ]);
    
        $kategoriPenilaian->update($request->only('aspek', 'deskripsi'));
    
        return redirect()->route('kategori.index')->with('success', 'Kategori diperbarui');
    }
    
    public function destroy(KategoriPenilaian $kategoriPenilaian)
    {
        $kategoriPenilaian->delete();
        return back()->with('success', 'Kategori dihapus');
    }
    
}
