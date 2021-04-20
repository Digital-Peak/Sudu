<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http\Middleware;

class HttpsProtocol
{
	public function handle($request, \Closure $next)
	{
		if (!$request->secure() && !config('app.debug')) {
			return redirect()->secure($request->getRequestUri());
		}

		return $next($request);
	}
}
