<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Posisi extends Model
{
    use HasFactory;

    protected $table = 'posisi';
    protected $primaryKey = 'id_posisi';
    public $incrementing = false; // id_posisi bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_posisi',
        'nama_posisi',

    ];

    protected static function boot()
    {
        parent::boot();

        parent::boot();

        static::creating(function ($posisi) {
            $lastId = self::latest('id_posisi')->first();
            
            // Jika ingin totalnya tepat 2 karakter (Awalan 'P' + 1 digit angka, misal: P1, P2... P9)
            $newId = $lastId ? 'P' . ((int) substr($lastId->id_posisi, 1) + 1) : 'P1';
            
            // Atau jika ingin formatnya selalu 2 digit angka (Misal: P01, P02... P99 - total 3 karakter), 
            // ganti angka 3 di bawah ini menjadi 1:
            // $newId = $lastId ? 'P' . str_pad((int) substr($lastId->id_posisi, 1) + 1, 1, '0', STR_PAD_LEFT) : 'P1';

            $posisi->id_posisi = $newId;
        });
    }


    public function kepanitiaan()
    {
        return $this->belongsTo(Kepanitiaan::class, 'id_panitia');
    }



}
