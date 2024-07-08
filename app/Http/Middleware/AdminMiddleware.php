<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna diautentikasi dan memiliki role admin
        if ($request->user() && $request->user()->role == 'owner') {
            return $next($request);
        }

        // Jika pengguna bukan admin, arahkan ulang mereka atau tampilkan pesan kesalahan
        return redirect('/login')->with('error', 'Anda tidak diperbolehkan mengakses halaman ini.');
    }
}
