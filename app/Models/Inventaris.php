<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventaris extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventaris';

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'tahun_pembelian',
        'lokasi',
        'keterangan',
    ];

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'inventaris_id');
    }
}
