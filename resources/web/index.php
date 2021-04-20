<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists(__DIR__ . '/../storage/framework/maintenance.php')) {
	require __DIR__ . '/../storage/framework/maintenance.php';
}

require __DIR__ . '/../vendor/autoload.php';

$app      = require_once __DIR__ . '/../bootstrap/app.php';
$kernel   = $app->make(Kernel::class);
$response = tap($kernel->handle($request = Request::capture()))->send();
$kernel->terminate($request, $response);
