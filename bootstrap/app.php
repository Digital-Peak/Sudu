<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

// Ensure database exists
if (!file_exists(dirname(__DIR__) . '/database/database.sqlite')) {
	copy(dirname(__DIR__) . '/database/database.sqlite.default', dirname(__DIR__) . '/database/database.sqlite');
}

$app = new Illuminate\Foundation\Application(
	$_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
	Illuminate\Contracts\Http\Kernel::class,
	Sudu\Http\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Console\Kernel::class,
	Sudu\Console\Kernel::class
);

$app->singleton(
	Illuminate\Contracts\Debug\ExceptionHandler::class,
	Sudu\Exceptions\Handler::class
);

return $app;
