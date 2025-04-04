<?php

namespace App\Http\Middleware;
use Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna terautentikasi di guard admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Jika tidak, arahkan ke halaman login admin
        return redirect('/login')->withErrors(['access' => 'You do not have access to this page.']);
    }
}
