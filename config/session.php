<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

return [
	'driver'          => env('SESSION_DRIVER', 'file'),
	'lifetime'        => env('SESSION_LIFETIME', 120),
	'expire_on_close' => false,
	'encrypt'         => false,
	'files'           => storage_path('framework/sessions'),
	'connection'      => env('SESSION_CONNECTION', null),
	'table'           => 'sessions',
	'store'           => env('SESSION_STORE', null),
	'lottery'         => [2, 100],
	'cookie'          => env('SESSION_COOKIE', \Illuminate\Support\Str::slug(env('APP_NAME', 'Sudu'), '_') . '_session'),
	'path'            => '/',
	'domain'          => env('SESSION_DOMAIN', null),
	'secure'          => env('SESSION_SECURE_COOKIE'),
	'http_only'       => true,
	'same_site'       => 'lax'
];
