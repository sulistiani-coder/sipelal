<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }
        $allowedRoles = array_unique(array_filter(array_map('trim', $allowedRoles)));

        if (!in_array(auth()->user()->role, $allowedRoles)) {
            abort(403, 'LU NGGAK PUNYA AKSES COK');
        }

        return $next($request);
    }
}
