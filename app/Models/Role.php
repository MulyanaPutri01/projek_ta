<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table ='role';

    protected $primarykey = 'id_role';
    public $incrementing ='false';
    public $timestamps = false;

    protected $fillable = ['id_role', 'nama_role'];

    public function takmirs(){
        return $this->hasMany(Takmir::class, 'role_id_role', 'id_role');
    }
}
