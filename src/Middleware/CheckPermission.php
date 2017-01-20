<?php

namespace NGiraud\ACL\Middleware;

use Closure;

class CheckPermission {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission) {
		if(!app('Illuminate\Contracts\Auth\Guard')->guest()) {
			if($request->user()->hasPermission($permission))
				return $next($request);
		}

		return $request->ajax() ? response('Unauthorized.', 401) : redirect(route('admin.home'));
	}
}
