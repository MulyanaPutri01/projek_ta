<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $primaryKey = 'id_inventaris';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_inventaris',
        'nama_barang',
        'jumlah',
        'tahun_pembelian',
        'lokasi',
        'keterangan',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inventaris) {
            $lastId = self::latest('id_inventaris')->first();
            $newId = $lastId ? 'I' . str_pad((int) substr($lastId->id_inventaris, 1) + 1, 2, '0', STR_PAD_LEFT) : 'I01';
            $inventaris->id_inventaris = $newId;
        });
    }


    public function catatan()
    {
        return $this->belongsTo(Catatan::class, 'catatan_id_catatan', 'id_catatan');
    }

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'inventaris_id_inventaris', 'id_inventaris');
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_id_kondisi');
    }




}
