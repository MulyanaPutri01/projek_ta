<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donatur extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'donatur';

    protected $fillable = [
        'tanggal',
        'nama_donatur',
        'alamat',
        'telepon',
        'takmir_id',
    ];

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'donatur_id');
    }
}
