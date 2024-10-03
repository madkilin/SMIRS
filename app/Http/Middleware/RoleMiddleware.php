<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan pengguna sudah login
        if (Auth::check()) {
            // Ambil role_id pengguna yang sedang login
            $userRole = Auth::user()->role_id;

            // Cek apakah role_id pengguna termasuk dalam array role yang diizinkan
            if (in_array($userRole, $roles)) {
                return $next($request);
            }

            // Jika role tidak sesuai, redirect ke halaman blank atau dashboard
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            return redirect()->route('admin.admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika tidak diizinkan, redirect ke login page
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
}
