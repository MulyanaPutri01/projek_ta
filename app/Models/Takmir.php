<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Takmir extends Authenticatable
{
    use HasFactory;

    protected $table = 'takmir';
    protected $primaryKey = 'id_takmir';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_takmir',
        'username',
        'password',
        'status',
        'role_id_role',
        'nama_takmir'];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id_role', 'id_role');
    }
    // Relasi ke Donatur
    public function donaturs()
    {
        return $this->hasMany(Donatur::class, 'takmir_id_takmir');
    }
    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'takmir_id_takmir');
    }
    
}
