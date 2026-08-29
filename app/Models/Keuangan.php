<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';
    protected $primaryKey = 'id_keuangan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'tanggal',
        'sumber_keuangan',
        'keterangan',
        'nominal',
        'kategori_id_kategori',
        'donatur_id_donatur',
        'kegiatan_id_kegiatan',
        'takmir_id_takmir',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastKeuangan = self::orderBy('id_keuangan', 'desc')->first();
            if ($lastKeuangan) {
                $lastId = intval(substr($lastKeuangan->id_keuangan, 1)) + 1;
                $model->id_keuangan= 'K' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
            } else {
                $model->id_keuangan = 'K0001';
            }
        });
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir');
    }

    public function kategori()

    {
        return $this->belongsTo(Kategori::class, 'kategori_id_kategori');
    }

    public function donatur()
    {
        return $this->belongsTo(Donatur::class, 'donatur_id_donatur');
    }


    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id_kegiatan', 'id_kegiatan');
    }


}
