<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donatur;
use App\Models\Takmir;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role->id_role;

        switch ($role) {
            case '1':
                return redirect()->route('admin.dashboard');
            case '2':
                return redirect()->route('bendahara.dashboard');
            case '3':
                return redirect()->route('sekretaris.dashboard');
            default:
                return redirect('/login');
        }


    }
}
