<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectOnUnauthorized
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->status() == 401 && !Auth::check()) {
            return redirect()->route('user-authentication'); 
        }

        return $response;
    }
}