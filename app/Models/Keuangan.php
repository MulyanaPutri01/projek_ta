<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'tanggal',
        'sumber_keuangan',
        'keterangan',
        'nominal',
        'kategori_id',
        'donatur_id',
        'kegiatan_id',
        'takmir_id',
    ];

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
