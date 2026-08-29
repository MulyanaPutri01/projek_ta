<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

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
