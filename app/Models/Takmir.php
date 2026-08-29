<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Takmir extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'takmir';

    protected $guard_name = 'web';

    protected $fillable = [
        'username',
        'password',
        'status',
        'role_id',
        'nama_takmir',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class, 'takmir_id');
    }

    public function donaturs()
    {
        return $this->hasMany(Donatur::class, 'takmir_id');
    }

    public function catatans()
    {
        return $this->hasMany(Catatan::class, 'takmir_id');
    }

    public function kepanitiaans()
    {
        return $this->hasMany(Kepanitiaan::class, 'takmir_id');
    }

    public function galeris()
    {
        return $this->hasMany(Galeri::class, 'takmir_id');
    }

    public function profilMasjids()
    {
        return $this->hasMany(ProfilMasjid::class, 'takmir_id');
    }
}
