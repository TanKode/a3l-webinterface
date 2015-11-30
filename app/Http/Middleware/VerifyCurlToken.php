<?php namespace A3LWebInterface\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class VerifyCurlToken {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!$request->isMethod('get')) {
			return response('Unauthorized.', 401);
		} else {
            if(Auth::guest()) {
                if(!Input::get('token', false)) {
                    return response('Unauthorized.', 401);
                } elseif(Input::get('token') != \Setting::get('curl.key')) {
                    return response('Unauthorized.', 401);
                }
            }
		}

		return $next($request);
	}

}
