<?php

namespace App\Policies;

use App\Models\Takmir;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TakmirPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function viewAny(User $user)
    {
        // Only admins can view any takmir records
        return $user->role->nama_role === 'admin';
    }

    public function update(User $user, Takmir $takmir)
    {
        // Only admin or bendahara can update takmir records
        return in_array($user->role->nama_role, ['admin', 'bendahara']);
    }

    public function delete(User $user, Takmir $takmir)
    {
        // Only admins can delete takmir records
        return $user->role->nama_role === 'admin';
    }
}
