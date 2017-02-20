<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class DBCheck
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            \DB::connection('mysql')->getDatabaseName();
            \DB::connection('arma')->getDatabaseName();
        } catch (\PDOException $e) {
            abort(503);
        }

        return $next($request);
    }
}
