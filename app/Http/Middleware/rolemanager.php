<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $authUserRole = Auth::user()->role;

    switch ($role) {
        case 'admin':
            if ($authUserRole == 'admin') {
                return $next($request);
            }
            // Jika user biasa coba masuk ke rute admin, lempar ke dashboard user
            return redirect()->route('dashboard');

        case 'user':
            if ($authUserRole == 'user') {
                return $next($request);
            }
            // Jika admin coba masuk ke rute user biasa, lempar ke dashboard admin
            return redirect()->route('admin.dashboard');
    }

    return $next($request);
}
}
