<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

return [
	'defaults'         => ['guard' => 'web', 'passwords' => 'users'],
	'guards'           => [
		'web' => ['driver' => 'session', 'provider' => 'users'],
		'api' => ['driver' => 'token', 'provider' => 'users', 'hash' => false]
	],
	'providers'        => ['users' => ['driver' => 'eloquent', 'model' => Sudu\Models\User::class]],
	'passwords'        => ['users' => ['provider' => 'users', 'table' => 'password_resets', 'expire' => 60, 'throttle' => 60]],
	'password_timeout' => 10800
];
