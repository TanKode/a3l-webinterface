<?php
namespace App\Http\Middleware;

use Illuminate\Http\Request;

class AntiIframe
{
    protected $blacklist = [
        'sw270887.wix.com',
    ];

    public function handle(Request $request, \Closure $next)
    {
        if ($request->is('error')) {
            abort(500);
        }
        return $next($request);
    }
}