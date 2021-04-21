<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Feature;

use Sudu\Tests\TestCase;

class WebTest extends TestCase
{
	public function testGetWebSite() {
		$this->copy($this->getProjectRoot() . '/public', $this->getRoot() . '/public');
		$this->copy($this->getProjectRoot() . '/resources', $this->getRoot() . '/resources');

		$response = $this->get('');
		$response->assertStatus(200);
		$response->assertSeeText('Testing');
	}
}
