<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'donatur';

    // Primary key dari tabel
    protected $primaryKey = 'id_donatur';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'id_donatur',
        'tanggal',
        'nama_donatur',
        'alamat',
        'takmir_id_takmir',
    ];

    // Jika primary key bukan auto increment, tambahkan:
    public $incrementing = false;

    // Format tipe data primary key
    protected $keyType = 'string';

    // Jika tabel tidak menggunakan timestamps, tambahkan:
    public $timestamps = false;

    // Relasi ke tabel takmir (jika diperlukan di masa depan)
    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir', 'id_takmir');
    }
    

}
