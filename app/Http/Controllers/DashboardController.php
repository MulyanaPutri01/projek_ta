<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        $role = Auth::user()?->role->nama_role;

        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role == 'bendahara') {
            return redirect()->route('bendahara.dashboard');
        } elseif ($role == 'sekretaris') {
            return redirect()->route('sekretaris.dashboard');
        }

        return redirect('/login');
    }
}
