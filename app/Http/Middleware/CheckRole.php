<?php
// ============================================================
// LOKASI FILE : app/Http/Middleware/CheckRole.php
// CARA BUAT   : php artisan make:middleware CheckRole
// ============================================================
// Setelah dibuat, daftarkan di bootstrap/app.php:
//
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias([
//         'role' => \App\Http\Middleware\CheckRole::class,
//     ]);
// })
// ============================================================

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Akun dinonaktifkan SuperAdmin
        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi SuperAdmin.');
        }

        // Role tidak sesuai
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}