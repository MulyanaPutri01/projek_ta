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
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $role = Auth::user()->role->id_role;

        switch ($role) {
            case '1':
                return '/admin-dashboard';
            case '2':
                return '/bendahara-dashboard';
            case '3':
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
