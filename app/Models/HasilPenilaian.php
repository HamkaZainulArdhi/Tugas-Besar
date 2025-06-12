<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPenilaian extends Model
{
    protected $fillable = [
        'jurnal_id',
        'kategori_penilaian_id',
        'reviewer_id', // Add this
        'is_accepted',
        'catatan'
    ];

    // Add relationships
    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }

    public function kategoriPenilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'kategori_penilaian_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}

