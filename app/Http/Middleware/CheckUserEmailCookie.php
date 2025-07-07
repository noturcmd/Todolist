<?php

// app/Http/Middleware/CheckUserEmailCookie.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserEmailCookie
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->cookie('user_email')) {
            return redirect('/login')->with('error', 'Sesi tidak ditemukan. Silakan login kembali.');
        }

        return $next($request);
    }
}


