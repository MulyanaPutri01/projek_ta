<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posisi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posisi';
    protected $fillable = ['nama_posisi'];

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class, 'posisi_id');
    }
}
