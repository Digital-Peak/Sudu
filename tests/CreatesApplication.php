<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;

/**
 * Creates an application for web requests.
 */
trait CreatesApplication
{
	/**
	 * Creates the application.
	 *
	 * @return Application
	 */
	public function createApplication() {
		$app = require __DIR__ . '/../bootstrap/app.php';

		$app->make(Kernel::class)->bootstrap();

		config(['app.name' => 'Testing', 'app.images_folder' => __DIR__ . '/tmp/images', 'app.debug' => true]);

		$commands = ['clear-compiled', 'cache:clear', 'view:clear', 'config:clear', 'route:clear'];
		foreach ($commands as $command) {
			Artisan::call($command);
		}

		return $app;
	}
}
