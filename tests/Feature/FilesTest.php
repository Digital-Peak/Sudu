<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Sudu\Models\User;
use Sudu\Tests\TestCase;

class FilesTest extends TestCase
{
	public function testGetRootFiles() {
		$response = $this->getJson('/api/v1/files');

		$response->assertStatus(200);
		$response->assertJson([
			[
				'title' => 'Testing',
				'path'  => '/',
				'type'  => 'dir'
			],
			[
				'title' => 'Image.jpg',
				'path'  => '/image.jpg',
				'type'  => 'image'
			],
			[
				'title' => 'Image.png',
				'path'  => '/image.png',
				'type'  => 'image'
			]
		]);
	}

	public function testGetRootFilesEmpty() {
		$this->deleteFs('');

		$response = $this->getJson('/api/v1/files');

		$response->assertStatus(200);
		$response->assertJson([['title' => 'Testing', 'path' => '/', 'type' => 'dir']]);
		$this->assertDirectoryExists($this->getImagesRoot());
	}

	public function testGetSubpath() {
		$this->copy('/image.jpg', '/sub/test.jpg');

		$response = $this->getJson('/api/v1/files/sub');

		$response->assertStatus(200);
		$response->assertJson([
			[
				'title' => 'Testing - Sub',
				'path'  => '/sub',
				'type'  => 'dir'
			],
			[
				'title' => '..',
				'path'  => '/',
				'type'  => 'dir'
			],
			[
				'title' => 'Test.jpg',
				'path'  => '/sub/test.jpg',
				'type'  => 'image'
			]
		]);
	}

	public function testGetNotExistingFolder() {
		$response = $this->getJson('/api/v1/files/invalid');

		$response->assertStatus(404);
		$response->assertExactJson(['message' => 'Path invalid not found on ' . $this->getImagesRoot()]);
	}

	public function testGetInvalidPath() {
		$response = $this->getJson('/api/v1/files/image.jpg');

		$response->assertStatus(200);
		$response->assertJson([
			[
				'title' => 'Testing',
				'path'  => '/',
				'type'  => 'dir'
			],
			[
				'title' => 'Image.jpg',
				'path'  => '/image.jpg',
				'type'  => 'image'
			],
			[
				'title' => 'Image.png',
				'path'  => '/image.png',
				'type'  => 'image'
			]
		]);
	}

	public function testCreateFolderRoot() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->postJson('/api/v1/files/folder/test');

		$response->assertStatus(200);
		$response->assertJson(['title' => 'Test', 'path' => '/test', 'type' => 'dir']);
	}

	public function testCreateFolderParent() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$this->createFolder('/sub');

		$response = $this->postJson('/api/v1/files/folder/sub/test');

		$response->assertStatus(200);
		$response->assertJson(['title' => 'Test', 'path' => '/sub/test', 'type' => 'dir']);
	}

	public function testCreateImage() {
		$this->deleteFs('');
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->postJson('/api/v1/files/images/new.jpg', ['file' => UploadedFile::fake()->image('new.jpg')]);

		$response->assertStatus(200);
		$response->assertJson(['title' => 'New.jpg', 'path' => '/new.jpg', 'type' => 'image']);
	}

	public function testDeleteImage() {
		Sanctum::actingAs(User::factory()->create(), ['*']);

		$response = $this->deleteJson('/api/v1/files/images/', ['images' => ['image.jpg']]);

		$response->assertStatus(200);
		$response->assertJsonCount(2);
		$response->assertJson([
			[
				'title' => 'Testing',
				'path'  => '/',
				'type'  => 'dir'
			],
			[
				'title' => 'Image.png',
				'path'  => '/image.png',
				'type'  => 'image'
			]
		]);
	}

	public function testDownloadArchive() {
		$response = $this->postJson('/api/v1/files/archive', ['images' => ['image.jpg']]);

		$response->assertStatus(200);
		$response->assertExactJson(['file' => '/archives/' . md5(serialize(['image.jpg'])) . '.zip']);
	}
}
