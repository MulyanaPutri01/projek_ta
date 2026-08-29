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

        if ($user->hasRole('admin') || $user->can('user-list') || $user->can('role-list')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('bendahara') || $user->can('keuangan-list')) {
            return redirect()->route('bendahara.dashboard');
        } elseif ($user->hasRole('sekretaris') || $user->can('kegiatan-list') || $user->can('inventaris-list')) {
            return redirect()->route('sekretaris.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }
}
