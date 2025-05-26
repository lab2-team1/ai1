<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->admin) {
            abort(403, 'Brak uprawnień do tej sekcji.');
        }
        return $next($request);
    }
}
