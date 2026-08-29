<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kepanitiaan extends Model
{
    use HasFactory;

    protected $table = 'kepanitiaan';

    protected $fillable = [
        'kegiatan_id',
        'jobdesk',
        'posisi_id',
        'takmir_id',
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function posisi()
    {
        return $this->belongsTo(Posisi::class, 'posisi_id');
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }
}
