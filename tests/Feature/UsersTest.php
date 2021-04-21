<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Feature;

use Laravel\Sanctum\Sanctum;
use Sudu\Models\User;
use Sudu\Tests\TestCase;

class UsersTest extends TestCase
{
	public function testGetMeNotAuthenticated() {
		$response = $this->getJson('/api/v1/users/me');

		$response->assertStatus(401);
	}

	public function testGetMeAuthenticated() {
		Sanctum::actingAs(User::factory()->create(['name' => 'admin']), ['*']);

		$response = $this->getJson('/api/v1/users/me');

		$response->assertStatus(200);
		$response->assertJson(['name' => 'admin']);
	}

	public function testUsersGet() {
		$user = User::factory()->create(['name' => 'test-user']);

		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->getJson('/api/v1/users/' . $user->id);

		$response->assertStatus(200);
		$response->assertJson(['name' => 'test-user']);
	}

	public function testUsersGetNotExisting() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->getJson('/api/v1/users/100');

		$response->assertStatus(404);
	}

	public function testUsersList() {
		Sanctum::actingAs(User::factory()->create(['name' => 'admin']), ['*']);

		User::factory()->create(['name' => 'test-user']);

		$response = $this->getJson('/api/v1/users');

		$response->assertStatus(200);
		$response->assertJsonCount(2);
		$response->assertJson([['name' => 'admin'], ['name' => 'test-user']]);
	}

	public function testUsersListOnlyAdmin() {
		Sanctum::actingAs(User::factory()->create(['name' => 'admin']), ['*']);

		$response = $this->getJson('/api/v1/users');

		$response->assertStatus(200);
		$response->assertJsonCount(1);
		$response->assertJson([['name' => 'admin']]);
	}

	public function testUsersCreate() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->postJson('/api/v1/users', ['name' => 'test', 'email' => 'test@example.com', 'password' => 'test']);

		$response->assertStatus(200);
		$response->assertJson(['name' => 'test', 'email' => 'test@example.com']);
	}

	/**
	 * @dataProvider invalidUserData
	 */
	public function testUsersCreateInvalidData($data) {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->postJson('/api/v1/users', $data);

		$response->assertStatus(422);
	}

	public function testUsersUpdate() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$user = User::factory()->create(['name' => 'test']);

		$response = $this->putJson(
			'/api/v1/users/' . $user->id,
			['name' => 'test edited', 'email' => 'testedited@example.com', 'password' => 'test']
		);

		$response->assertStatus(200);
		$response->assertJson(['name' => 'test edited', 'email' => 'testedited@example.com']);
	}

	/**
	 * @dataProvider invalidUserData
	 */
	public function testUsersUpdateInvalidData($data) {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$user = User::factory()->create(['name' => 'test']);

		$response = $this->putJson('/api/v1/users/' . $user->id, $data);

		$response->assertStatus($data['password'] ? 422 : 200);
	}

	public function testUsersUpdateInvalid() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->putJson('/api/v1/users/100', ['name' => 'test edited', 'email' => 'testedited@example.com', 'password' => 'test']);

		$response->assertStatus(404);
	}

	public function testUsersDelete() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$user = User::factory()->create(['name' => 'test']);

		$response = $this->deleteJson('/api/v1/users/' . $user->id);

		$response->assertStatus(200);
	}

	public function testUsersDeleteInvalid() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->deleteJson('/api/v1/users/100');

		$response->assertStatus(404);
	}

	public function invalidUserData(): array {
		return [
			[['name' => 'test', 'email' => 'test', 'password' => 'test']],
			[['name' => '', 'email' => 'test@example.com', 'password' => 'test']],
			[['name' => 'test', 'email' => 'test@example.com', 'password' => '']],
			[['name' => 'test', 'email' => '', 'password' => 'test']]
		];
	}
}
