<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Feature;

use Sudu\Models\User;
use Sudu\Tests\TestCase;

class LoginTest extends TestCase
{
	public function itestLogin()
	{
		$user = User::factory()->create(['email' => 'admin@example.com', 'password' => bcrypt('test')]);

		$response = $this->startSession()->postJson('/api/v1/user/login', ['email' => 'admin@example.com', 'password' => 'test']);

		$response->assertStatus(200);
		$response->assertJson(['email' => 'admin@example.com']);
		$this->assertAuthenticatedAs($user);
	}
}
