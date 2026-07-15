<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ! in_array($user->status, ['ACTIVE'], true)) {
            Auth::logout();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum aktif atau ditangguhkan. Silakan hubungi administrator.']);
        }

        return $next($request);
    }
}
