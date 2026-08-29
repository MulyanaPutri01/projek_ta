<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';
    protected $primaryKey = 'id_galeri';
    public $incrementing = false; // id_kegiatan bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'nama_foto',
        'gambar',
        'kegiatan_id_kegiatan',
        'takmir_id_takmir',
    ];

    // Relasi ke tabel takmir
    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir', 'id_takmir');
    }

    // Relasi ke tabel kegiatan
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id_kegiatan', 'id_kegiatan');
    }

    // Boot method untuk custom ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $lastId = self::latest('id_galeri')->first();
            $newId = $lastId ? 'G' . str_pad((int) substr($lastId->id_galeri, 1) + 1, 2, '0', STR_PAD_LEFT) : 'G01';
            $galeri->id_galeri = $newId;
        });
    }
}

