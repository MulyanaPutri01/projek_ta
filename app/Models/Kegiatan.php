<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'mulai_kegiatan',
        'akhir_kegiatan',
        'nama_waktu',
        'pembicara',
        'nama_khotib',
        'nama_muadzin',
        'tempat',
        'audience',
    ];

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'kegiatan_id');
    }

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class, 'kegiatan_id');
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class, 'kegiatan_id');
    }
}
