<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'catatan';

    protected $fillable = [
        'inventaris_id',
        'tanggal_catatan',
        'kondisi_id',
        'takmir_id',
    ];

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }

    public function kondisi()
    {
        return $this->belongsTo(Kondisi::class, 'kondisi_id');
    }

    public function takmir()
    {
        return $this->belongsTo(Takmir::class, 'takmir_id');
    }
}
