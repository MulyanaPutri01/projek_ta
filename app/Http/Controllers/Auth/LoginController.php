<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Takmir;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $role = Auth::user()?->role?->nama_role;

        switch ($role) {
            case 'admin':
                return '/admin-dashboard';
            case 'bendahara':
                return '/bendahara-dashboard';
            case 'sekretaris':
                return '/sekretaris-dashboard';
            default:
                return '/dashboard';
        }
    }

    protected function attemptLogin(Request $request)
    {
        $takmir = Takmir::where('username', $request->username)->first();

        if ($takmir && Hash::check($request->password, $takmir->password)) {
            Auth::login($takmir);
            return true;
        }

        return false;
    }
}
