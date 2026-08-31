<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }

        // Pastikan relasi peran Spatie tersinkronisasi jika belum ada
        if ($user->role && $user->roles->isEmpty()) {
            $user->syncRoles([strtolower($user->role->nama_role)]);
            $user->refresh();
        }

        $roleName = strtolower($user->role?->nama_role ?? ($user->roles->first()?->name ?? ''));

        if ($roleName === 'admin' || $user->hasRole('admin') || $user->can('user-list') || $user->can('role-list')) {
            return redirect()->route('admin.dashboard');
        } elseif ($roleName === 'bendahara' || $user->hasRole('bendahara') || $user->can('keuangan-list')) {
            return redirect()->route('bendahara.dashboard');
        } elseif ($roleName === 'sekretaris' || $user->hasRole('sekretaris') || $user->can('kegiatan-list') || $user->can('inventaris-list')) {
            return redirect()->route('sekretaris.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }
}
