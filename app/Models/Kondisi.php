<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Kondisi extends Model
{
    use HasFactory;

    protected $table = 'kondisi';
    protected $primaryKey = 'id_kondisi';
    public $incrementing = false; // id_kondisi bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kondisi',
        'nama_kondisi',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kondisi) {
            $lastId = self::latest('id_kondisi')->first();
            // Generate new id based on the last id, incrementing by 1, starting from K1
            $newId = $lastId ? 'K' . ((int) substr($lastId->id_kondisi, 1) + 1) : 'K1';
            $kondisi->id_kondisi = $newId;
        });
    }


    public function catatan()
    {
        return $this->belongsTo(Catatan::class, 'id_catatan');
    }

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'id_kondisi', 'id_kondisi');
    }

    public function inventariss()
    {
        return $this->hasMany(Inventaris::class, 'kondisi_id_kondisi', 'id_kondisi');
    }



}
