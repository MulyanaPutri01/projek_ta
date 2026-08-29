<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'tanggal',
        'nama_foto',
        'gambar',
        'kegiatan_id',
        'takmir_id',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }
}
