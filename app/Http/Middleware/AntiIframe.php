<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class AntiIframe
{
    public function handle(Request $request, \Closure $next)
    {
        if ($request->is('error')) {
            abort(500);
        }

        return $next($request);
    }
}
