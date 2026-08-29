<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';
    public $incrementing = false; // id_kegiatan bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kegiatan',
        'nama_kegiatan',
        'tanggal',
        'mulai_kegiatan',
        'akhir_kegiatan',
        'nama_waktu',
        'pembicara',
        'tempat',
        'audience'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kegiatan) {
            $lastId = self::latest('id_kegiatan')->first();
            $newId = $lastId ? 'A' . str_pad((int) substr($lastId->id_kegiatan, 1) + 1, 3, '0', STR_PAD_LEFT) : 'A001';
            $kegiatan->id_kegiatan = $newId;
        });
    }

    public function keuangan()
    {
        return $this->belongsTo(Keuangan::class, 'id_keuangan');
    }
    public function kepanitiaan()
    {
        return $this->belongsTo(Kepanitiaan::class, 'id_panitia');
    }


}
