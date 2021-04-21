<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = ['current_password', 'password', 'password_confirmation',];

	/**
	 * Register the exception handling callbacks for the application.
	 *
	 * @return void
	 */
	public function register() {
		$this->reportable(function (Throwable $e) {
		});
	}

	public function render($request, Throwable $e) {
		$code = $e->getCode();
		if (!$code && $e instanceof AuthenticationException) {
			$code = 401;
		}
		if (!$code && $e instanceof ValidationException) {
			$code = 422;
		}

		return response()->json(['message' => $e->getMessage()], $code ?: 500);
	}
}
