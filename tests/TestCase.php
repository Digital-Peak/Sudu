<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Basic test case for web based tests
 */
abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
	use CreatesApplication, FileOperations, RefreshDatabase;
}
