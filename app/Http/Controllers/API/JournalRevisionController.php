<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\journal_revisions;

class JournalRevisionController extends Controller
{
    // Read (get all journal revisions)
    public function index()
    {
        $revisions = journal_revisions::with(['journal', 'user'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $revisions
        ]);
    }

    // Create (store a new revision)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'journal_id' => 'required|exists:jurnals,id',
            'user_id' => 'required|exists:users,id',
            'file_pdf' => 'required|string',
            'revision_notes' => 'nullable|string',
            'status' => 'in:pending,reviewed',
        ]);

        $revision = journal_revisions::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Revisi jurnal berhasil ditambahkan',
            'data' => $revision
        ], 201);
    }
}



