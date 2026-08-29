<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $roleName = Auth::user()?->role?->nama_role;

        switch ($roleName) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'bendahara':
                return redirect()->route('bendahara.dashboard');
            case 'sekretaris':
                return redirect()->route('sekretaris.dashboard');
            default:
                return redirect('/login');
        }
    }
}
