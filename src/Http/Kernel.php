<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		// \Sudu\Http\Middleware\TrustHosts::class,
		\Sudu\Http\Middleware\TrustProxies::class,
		\Fruitcake\Cors\HandleCors::class,
		\Sudu\Http\Middleware\PreventRequestsDuringMaintenance::class,
		\Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
		\Sudu\Http\Middleware\TrimStrings::class,
		\Sudu\Http\Middleware\HttpsProtocol::class,
		\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\Sudu\Http\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			// \Illuminate\Session\Middleware\AuthenticateSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Sudu\Http\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class
		],

		'api' => [
			\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
			'throttle:api',
			\Illuminate\Routing\Middleware\SubstituteBindings::class
		]
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth'             => \Sudu\Http\Middleware\Authenticate::class,
		'auth.basic'       => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'cache.headers'    => \Illuminate\Http\Middleware\SetCacheHeaders::class,
		'can'              => \Illuminate\Auth\Middleware\Authorize::class,
//		'guest'            => \Sudu\Http\Middleware\RedirectIfAuthenticated::class,
		'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
		'signed'           => \Illuminate\Routing\Middleware\ValidateSignature::class,
		'throttle'         => \Illuminate\Routing\Middleware\ThrottleRequests::class,
		'verified'         => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class
	];
}
