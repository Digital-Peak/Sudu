<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	public function handle(Request $request, Closure $next, ...$guards) {
		$guards = empty($guards) ? [null] : $guards;

		foreach ($guards as $guard) {
			if (Auth::guard($guard)->check()) {
//				return redirect('/api/v1/users/get/me');
			}
		}

		return $next($request);
	}
}
