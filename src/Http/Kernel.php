<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http;

use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Sudu\Http\Middleware\Authenticate;
use Sudu\Http\Middleware\EncryptCookies;
use Sudu\Http\Middleware\HttpsProtocol;
use Sudu\Http\Middleware\PreventRequestsDuringMaintenance;
use Sudu\Http\Middleware\TrimStrings;
use Sudu\Http\Middleware\TrustProxies;
use Sudu\Http\Middleware\VerifyCsrfToken;

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
		TrustProxies::class,
		HandleCors::class,
		PreventRequestsDuringMaintenance::class,
		ValidatePostSize::class,
		TrimStrings::class,
		HttpsProtocol::class,
		ConvertEmptyStringsToNull::class
	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			EncryptCookies::class,
			AddQueuedCookiesToResponse::class,
			StartSession::class,
			// \Illuminate\Session\Middleware\AuthenticateSession::class,
			ShareErrorsFromSession::class,
			VerifyCsrfToken::class,
			SubstituteBindings::class
		],

		'api' => [
			EnsureFrontendRequestsAreStateful::class,
			'throttle:api',
			SubstituteBindings::class
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
		'auth'             => Authenticate::class,
		'auth.basic'       => AuthenticateWithBasicAuth::class,
		'cache.headers'    => SetCacheHeaders::class,
		'can'              => Authorize::class,
//		'guest'            => \Sudu\Http\Middleware\RedirectIfAuthenticated::class,
		'password.confirm' => RequirePassword::class,
		'signed'           => ValidateSignature::class,
		'throttle'         => ThrottleRequests::class,
		'verified'         => EnsureEmailIsVerified::class
	];
}
