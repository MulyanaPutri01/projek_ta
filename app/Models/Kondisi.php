<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kondisi extends Model
{
    use HasFactory;

    protected $table = 'kondisi';
    protected $fillable = ['nama_kondisi'];

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'kondisi_id');
    }
}
