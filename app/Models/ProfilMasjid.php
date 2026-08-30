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
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'judul_infaq',
        'deskripsi_infaq',
        'foto_masjid',
        'takmir_id',
    ];

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }
}
