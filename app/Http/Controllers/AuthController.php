<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return $this->loginForm();
    }

    public function loginForm()
    {
        if (Auth::check()) {
            $role = Auth::user()?->role?->nama_role;
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'bendahara') {
                return redirect()->route('bendahara.dashboard');
            } elseif ($role === 'sekretaris') {
                return redirect()->route('sekretaris.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:30',
            'password' => 'required|string|min:8|max:20',
        ]);

        $takmir = Takmir::where('username', $request->username)->first();

        if ($takmir && Hash::check($request->password, $takmir->password)) {
            if ($takmir->status !== 'active') {
                return back()->withErrors(['username' => 'Akun Anda sedang nonaktif. Silakan hubungi admin.']);
            }

            Auth::login($takmir);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah!']);
    }

    public function showRegisterForm()
    {
        return $this->registerForm();
    }

    public function registerForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_takmir' => 'required|string|max:50',
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:role,id',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $takmir = new Takmir();
        $takmir->username = $request->username;
        $takmir->password = Hash::make($request->password);
        $takmir->role_id = $request->role_id;
        $takmir->status = 'active'; // Default status aktif
        $takmir->nama_takmir = $request->nama_takmir;
        $takmir->save();

        Auth::login($takmir);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
