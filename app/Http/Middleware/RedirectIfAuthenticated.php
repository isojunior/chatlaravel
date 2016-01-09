<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated {
	protected $auth;

	public function __construct() {
		$this->auth = Session::get('user');
	}

	public function handle($request, Closure $next) {
		if (!isset($this->auth)) {
			return redirect("/");
		}

		return $next($request);
	}
}
