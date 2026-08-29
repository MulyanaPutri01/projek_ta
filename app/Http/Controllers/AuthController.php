<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Check the user's role and redirect accordingly
            if (Auth::user()->role->nama_role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role->nama_role === 'bendahara') {
                return redirect()->route('bendahara.dashboard');
            } elseif (Auth::user()->role->nama_role === 'sekretaris') {
                return redirect()->route('sekretaris.dashboard');
            }
        }

        // If not authenticated, show the login form
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
            Auth::login($takmir);
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah!']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8|confirmed',
            'role_id_role' => 'required|exists:role,id_role',
        ]);

        $takmir = new Takmir();
        $takmir->id_takmir = uniqid();
        $takmir->username = $request->username;
        $takmir->password = Hash::make($request->password);
        $takmir->role_id_role = $request->role_id_role;
        $takmir->status = 'aktif'; // Default status
        $takmir->nama_takmir = $request->nama_takmir;
        $takmir->save();

        Auth::login($takmir);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Redirect to login page after logout
    }

}
