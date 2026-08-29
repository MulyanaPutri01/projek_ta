<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // If the user is logged in and their role is 'admin', allow access to all routes
        //if (Auth::check() && Auth::user()->role->nama_role === 'admin') {
           // return $next($request);
        //}

        // If the user's role matches the requested role, allow access
       // if (Auth::check() && Auth::user()->role->nama_role === $role) {
         //   return $next($request);
        //}

       // Cek apakah user login dan relasi role ada
        if (Auth::check() && Auth::user()->role) {
            $userRole = strtolower(trim(Auth::user()->role->nama_role));

            // Cocokkan langsung role pengguna dengan role yang diminta
            if ($userRole === strtolower(trim($role))) {
                return $next($request);
            }
        }
        abort(403, 'Akses Ditolak');
    }
}
