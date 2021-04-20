<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

return [
	'stateful'   => explode(',', env('SANCTUM_STATEFUL_DOMAINS', $_SERVER['HTTP_HOST'])),
	'expiration' => null,
	'middleware' => [
		'verify_csrf_token' => Sudu\Http\Middleware\VerifyCsrfToken::class,
		'encrypt_cookies'   => Sudu\Http\Middleware\EncryptCookies::class
	]
];
