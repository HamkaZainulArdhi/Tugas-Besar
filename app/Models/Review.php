<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['jurnal_id', 'checklist', 'corrections', 'corrected_pdf_path', 'reviewer_id'];

    protected $casts = [
        'checklist' => 'array',
    ];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    // public function reviewer()
    // {
    //     return $this->belongsTo(User::class, 'reviewer_id');
    // }
}


