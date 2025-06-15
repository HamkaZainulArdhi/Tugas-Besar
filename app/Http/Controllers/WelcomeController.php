<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurnal::with(['user', 'hasilPenilaian'])
            ->whereHas('hasilPenilaian', function($q) {
                $q->where('is_accepted', true);
            });

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('abstrak', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Get all categories for filter dropdown
        $categories = Jurnal::whereHas('hasilPenilaian', function($q) {
            $q->where('is_accepted', true);
        })->distinct()->pluck('kategori')->filter()->sort();

        $jurnals = $query->latest()->paginate(12)->appends($request->query());

        return view('welcome', compact('jurnals', 'categories'));
    }

    public function download($id)
    {
        $jurnal = Jurnal::whereHas('hasilPenilaian', function($q) {
            $q->where('is_accepted', true);
        })->findOrFail($id);

        if (!$jurnal->file_pdf || !Storage::disk('public')->exists($jurnal->file_pdf)) {
            abort(404, 'File not found');
        }

        $filePath = storage_path('app/public/' . $jurnal->file_pdf);
        $fileName = $jurnal->judul . '.pdf';

        return response()->download($filePath, $fileName);
    }
}