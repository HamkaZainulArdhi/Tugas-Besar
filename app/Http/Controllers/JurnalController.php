<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Models\KategoriPenilaian;
use App\Models\HasilPenilaian;
use App\Models\journal_revisions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::latest()->get();
        return view('jurnal.jurnalmain', compact('jurnals'));
    }

    public function store(Request $request)
    {   
    try {
        // Validasi input
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'kategori' => 'nullable|string',
            'abstrak' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Proses upload file
        $filePath = null;
        if ($request->hasFile('file_pdf')) {
            $filePath = $request->file('file_pdf')->store('jurnals', 'public');
        }

        // Simpan data
        $user = Auth::user();
        $user->jurnals()->create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'email' => $user->email,
            'kategori' => $request->kategori,
            'abstrak' => $request->abstrak,
            'file_pdf' => $filePath,
        ]);

        // SUCCESS ALERT
        return back()->with('alert', [
            'type' => 'success',
            'title' => 'Berhasil!',
            'message' => 'Jurnal berhasil ditambahkan ke sistem.'
        ]);

    } catch (Exception $e) {
        // ERROR ALERT
        return back()
            ->withInput()
            ->with('alert', [
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => 'Terjadi kesalahan saat menyimpan jurnal.'
            ]);
    }
}

    public function showByFilename($filename)
    {
        $jurnals = Jurnal::with('user')->where('file_pdf', $filename)->firstOrFail();

        // Ambil checklist dari tabel kategori_penilaian
        $checklistItems = KategoriPenilaian::all();

        return view('jurnal.jurnalshow', compact('jurnals', 'checklistItems'));
    }

    public function submitReview(Request $request, $jurnalId)
    {
        $request->validate([
            'checklist_accept' => 'array',
            'checklist_reject' => 'array', 
            'catatan' => 'nullable|string',
        ]);

        $accepts = $request->checklist_accept ?? [];
        $rejects = $request->checklist_reject ?? [];
        $catatan = $request->input('catatan');
        $reviewerId = Auth::id();

        // Debug information
        Log::info('Review Submission:', [
            'jurnal_id' => $jurnalId,
            'reviewer_id' => $reviewerId,
            'accepts' => $accepts,
            'rejects' => $rejects,
            'catatan' => $catatan
        ]);

        try {
            // Bersihkan hasil lama reviewer ini untuk jurnal ini
            HasilPenilaian::where('jurnal_id', $jurnalId)
                ->where('reviewer_id', $reviewerId)
                ->delete();

            // Gabungkan hasil baru
            foreach (KategoriPenilaian::all() as $index => $item) {
                $isAccepted = null;
                if (in_array($item->id, array_map('intval', $accepts))) {
                    $isAccepted = true;
                } elseif (in_array($item->id, array_map('intval', $rejects))) {
                    $isAccepted = false;
                }

                if (!is_null($isAccepted)) {
                    HasilPenilaian::create([
                        'jurnal_id' => $jurnalId,
                        'kategori_penilaian_id' => $item->id,
                        'reviewer_id' => $reviewerId,
                        'is_accepted' => $isAccepted,
                        'catatan' => $catatan,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Review berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error saving review:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan review.')
                ->withInput();
        }
    }

}
