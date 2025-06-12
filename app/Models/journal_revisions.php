<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class journal_revisions extends Model
{
    protected $fillable = [
        'journal_id',
        'user_id', 
        'file_pdf',
        'revision_notes',
        'status'
    ];

    public function journal()
    {
        return $this->belongsTo(Jurnal::class, 'journal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
