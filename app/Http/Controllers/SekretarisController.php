<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SekretarisController extends Controller
{
    public function index()
    {
        return view('sekretaris.dashboard');
    }
}
