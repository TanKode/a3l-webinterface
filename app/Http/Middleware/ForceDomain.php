<?php
namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ForceDomain
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, \Closure $next)
    {
        if ($request->server('HTTP_HOST') != $request->server('SERVER_NAME')) {
            return redirect()->to(
                $request->server('HTTP_X_FORWARDED_PROTO') . '://' .
                $request->server('SERVER_NAME') . '/' .
                trim($request->server('REQUEST_URI'), '/')
            );
        }
        return $next($request);
    }
}