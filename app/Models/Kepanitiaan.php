<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepanitiaan extends Model
{
    use HasFactory;

    protected $table = 'kepanitiaan';
    protected $primaryKey = 'id_panitia';
    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kegiatan_id_kegiatan',
        'jobdesk',
        'posisi_id_posisi',
        'takmir_id_takmir',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kepanitiaan) {
            // Ambil id_panitia terakhir dari database
            $lastId = self::latest('id_panitia')->first();

            // Periksa apakah ada id_panitia sebelumnya, jika ada, tambahkan 1
            if ($lastId) {
                $lastNumber = (int) substr($lastId->id_panitia, 2); // Ambil angka setelah "PA"
                $newId = 'PA' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Tambahkan 1 dan format
            } else {
                // Jika belum ada data, mulai dengan PA001
                $newId = 'PA001';
            }

            // Set id_panitia baru ke model
            $kepanitiaan->id_panitia = $newId;
        });
    }


    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id_kegiatan', 'id_kegiatan');
    }

    public function posisi()
    {
        return $this->belongsTo(Posisi::class, 'posisi_id_posisi', 'id_posisi');
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id_takmir', 'id_takmir');
    }


}
