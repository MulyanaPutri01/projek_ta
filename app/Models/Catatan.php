<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'catatan'; // Nama tabel
    protected $primaryKey = 'id_catatan'; // Primary key

    public $incrementing = false; // Jika menggunakan ID custom
    public $timestamps = false; // Jika tabel tidak memiliki kolom created_at dan updated_at

    protected $fillable = [
        'id_catatan',
        'inventaris_id_inventaris',
        'tanggal_catatan',
        'kondisi_id_kondisi',
        'keterangan',
        'takmir_id_takmir',
    ];

    // Relasi ke tabel lain
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id_inventaris', 'id_inventaris');
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_id_kondisi', 'id_kondisi');
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir', 'id_takmir');
    }
}

