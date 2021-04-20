<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

return [
	'default'  => env('LOG_CHANNEL', 'stack'),
	'channels' => [
		'stack'      => [
			'driver'            => 'stack',
			'channels'          => ['single'],
			'ignore_exceptions' => false,
		],
		'single'     => [
			'driver' => 'single',
			'path'   => storage_path('logs/laravel.log'),
			'level'  => env('LOG_LEVEL', 'warning'),
		],
		'daily'      => [
			'driver' => 'daily',
			'path'   => storage_path('logs/laravel.log'),
			'level'  => env('LOG_LEVEL', 'warning'),
			'days'   => 14,
		],
		'slack'      => [
			'driver'   => 'slack',
			'url'      => env('LOG_SLACK_WEBHOOK_URL'),
			'username' => 'Laravel Log',
			'emoji'    => ':boom:',
			'level'    => env('LOG_LEVEL', 'critical')
		],
		'papertrail' => [
			'driver'       => 'monolog',
			'level'        => env('LOG_LEVEL', 'warning'),
			'handler'      => \Monolog\Handler\SyslogUdpHandler::class,
			'handler_with' => ['host' => env('PAPERTRAIL_URL'), 'port' => env('PAPERTRAIL_PORT')]
		],
		'stderr'     => [
			'driver'    => 'monolog',
			'level'     => env('LOG_LEVEL', 'warning'),
			'handler'   => \Monolog\Handler\StreamHandler::class,
			'formatter' => env('LOG_STDERR_FORMATTER'),
			'with'      => ['stream' => 'php://stderr']
		],
		'syslog'     => ['driver' => 'syslog', 'level' => env('LOG_LEVEL', 'warning')],
		'errorlog'   => ['driver' => 'errorlog', 'level' => env('LOG_LEVEL', 'warning')],
		'null'       => ['driver' => 'monolog', 'handler' => \Monolog\Handler\NullHandler::class],
		'emergency'  => ['path' => storage_path('logs/laravel.log'),]
	]
];
