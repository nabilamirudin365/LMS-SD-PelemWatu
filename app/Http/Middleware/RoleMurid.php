<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMurid
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'murid') {
            return $next($request);
        }

        abort(403, 'Akses ini hanya untuk murid.');
    }
}
