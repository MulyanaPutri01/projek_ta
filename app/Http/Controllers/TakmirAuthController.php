<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Takmir;
use App\Models\Donatur;


class TakmirAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('takmir')->attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke halaman berdasarkan role setelah login
            $role = Auth::guard('takmir')->user()->role->nama_role;
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'bendahara') {
                return redirect()->intended('/bendahara/dashboard');
            } elseif ($role === 'sekretaris') {
                return redirect()->intended('/sekretaris/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('takmir')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
