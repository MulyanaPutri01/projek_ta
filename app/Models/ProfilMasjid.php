<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMasjid extends Model
{
    use HasFactory;

    protected $table = 'profil_masjid';

    protected $fillable = [
        'nama_masjid',
        'sejarah',
        'visi',
        'misi',
        'alamat',
        'telepon',
        'foto_masjid',
        'takmir_id',
    ];

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }
}
