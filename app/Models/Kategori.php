<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_kategori',
    ];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'id_kategori', 'id_keuangan');

    }
}
