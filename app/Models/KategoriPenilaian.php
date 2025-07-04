<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPenilaian extends Model
{
    protected $fillable = ['aspek', 'deskripsi'];
    public $timestamps = false;
    
    public function hasilPenilaian()
    {
        return $this->hasMany(HasilPenilaian::class);
    }
}


