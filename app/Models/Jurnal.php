<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'email',
        'kategori',
        'abstrak',
        'file_pdf',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function revisions()
    {
        return $this->hasMany(journal_revisions::class, 'journal_id');
    }

        public function hasilPenilaian()
    {
        return $this->hasMany(HasilPenilaian::class, 'jurnal_id');
    }


}
