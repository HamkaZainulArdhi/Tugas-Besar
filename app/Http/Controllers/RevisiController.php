<?php

namespace App\Http\Controllers;

use App\Models\journal_revisions;
use App\Models\Jurnal;
use App\Models\HasilPenilaian;
use Illuminate\Http\Request;

class RevisiController extends Controller
{
    public function index()
    {
        if (auth()->user()->usertype === 'admin') {
            // For admin: load journals with user and assessment data
            $jurnals = Jurnal::whereHas('revisions')  // This ensures only journals with revisions are loaded
            ->with(['user', 'hasilPenilaian.kategoriPenilaian', 'hasilPenilaian.reviewer'])
            ->latest()
            ->get();
        $hasilPenilaians = null;
        $catatan = null;
        } else {
            // For user: load their journals with all related data
            $jurnals = Jurnal::where('user_id', auth()->id())
                ->with(['HasilPenilaian.KategoriPenilaian', 'revisions'])
                ->latest()
                ->get();
                
            // Get the latest journal's assessment data
            $latestJurnal = $jurnals->first();
            $hasilPenilaians = $latestJurnal ? HasilPenilaian::with(['kategoriPenilaian', 'reviewer'])
                ->where('jurnal_id', $latestJurnal->id)
                ->get() : collect();
                
            // Get single note from the latest assessment
            $catatan = $hasilPenilaians->isNotEmpty() ? $hasilPenilaians->first()->catatan : null;
        }
        
        return view('revisi.hasilnilai', compact('jurnals', 'hasilPenilaians', 'catatan'));
    }
    


    public function show($id)
    {
        $jurnal = Jurnal::with(['revisions', 'user'])->findOrFail($id);
        $hasilPenilaian = HasilPenilaian::with('kategoriPenilaian')
            ->where('jurnal_id', $id)
            ->get();

        $revisions = $jurnal->revisions;
        return view('revisi.index', compact('jurnal', 'hasilPenilaian', 'revisions'));
    }

    public function uploadRevision(Request $request, $id)
    {
        $request->validate([
            'file_pdf' => 'required|file|mimes:pdf|max:2048',
            'revision_notes' => 'nullable|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        
        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('revisions', 'public');
            
            journal_revisions::create([  // Changed from journal_revisions
                'jurnal_id' => $jurnal->id,  // Changed from journal_id
                'user_id' => auth()->id(),
                'file_pdf' => $filePath,
                'revision_notes' => $request->revision_notes,
            ]);

            return back()->with('success', 'Revisi berhasil diupload.');
        }

        return back()->with('error', 'Terjadi kesalahan saat upload file.');
    }

    public function hasilNilai(Jurnal $jurnal)
    {
        $hasilPenilaians = HasilPenilaian::with(['kategoriPenilaian', 'reviewer'])
            ->where('jurnal_id', $jurnal->id)
            ->get();
    
        return view('revisi.index', compact('jurnal', 'hasilPenilaians'));
    }

    public function create(Jurnal $jurnal)
    {
        // Check if user owns the journal or is admin
        if (auth()->id() !== $jurnal->user_id && auth()->user()->usertype !== 'admin') {
            abort(403);
        }

        $hasilPenilaian = HasilPenilaian::with('kategoriPenilaian')
            ->where('jurnal_id', $jurnal->id)
            ->get();

        return view('revisi.create', compact('jurnal', 'hasilPenilaian'));
    }

    public function store(Request $request, Jurnal $jurnal)
{
    // Validasi
    $validated = $request->validate([
        'file_pdf' => 'required|mimes:pdf|max:2048',
        'revision_notes' => 'nullable|string',
    ]);

    // Simpan file PDF
    if ($request->hasFile('file_pdf')) {
        $path = $request->file('file_pdf')->store('revisions', 'public');
    }

    // Simpan data revisi
    $jurnal->revisions()->create([
        'user_id' => auth()->id(),
        'file_pdf' => $path,
        'revision_notes' => $validated['revision_notes'],
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Revisi berhasil dikirim.');
}


    
}

