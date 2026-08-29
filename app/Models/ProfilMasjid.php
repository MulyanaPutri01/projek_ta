<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMasjid extends Model
{
    use HasFactory;
    protected $table = 'profil_masjid';
    protected $primaryKey = 'id_profil';

    // Konfigurasi Primary Key Non-Incrementing String
    public $incrementing = false;
    protected $keyType = 'string';

    // Matikan timestamp otomatis Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_profil',
        'nama_masjid',
        'sejarah',
        'visi',
        'misi',
        'alamat',
        'telepon',
        'takmir_id_takmir',
    ];
    // Relasi ke Takmir
    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir', 'id_takmir');
    }
}
