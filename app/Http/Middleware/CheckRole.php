<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika pengguna tidak login, hentikan
        if (!Auth::check()) {
            return redirect('login');
        }

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak diizinkan, kembalikan halaman 403 (Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
    }
}
