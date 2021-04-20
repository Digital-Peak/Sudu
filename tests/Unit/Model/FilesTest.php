<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Unit\Model;

use Sudu\Models\Files;
use Sudu\Tests\FileOperations;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
	use FileOperations;

	public function testFiles()
	{
		$model = new Files();
		$files = $model->getFiles($this->getImagesRoot(), 'TestApp');

		$this->assertCount(3, $files);
		$this->assertEquals('TestApp', $files[0]->title);
		$this->assertEquals('dir', $files[0]->type);
		$this->assertEquals('Image.jpg', $files[1]->title);
		$this->assertEquals('image', $files[1]->type);
		$this->assertEquals('Image.png', $files[2]->title);
		$this->assertEquals('image', $files[2]->type);
	}

	public function testFilesInSubfolder()
	{
		$this->copy('image.jpg', '/sub/image.jpg');

		$model  = new Files();
		$images = $model->getFiles($this->getImagesRoot() . '/sub', 'TestApp');

		$this->assertCount(3, $images);
		$this->assertEquals('TestApp - Sub', $images[0]->title);
		$this->assertEquals('dir', $images[0]->type);
		$this->assertEquals('..', $images[1]->title);
		$this->assertEquals('dir', $images[1]->type);
		$this->assertEquals('Image.jpg', $images[2]->title);
		$this->assertEquals('image', $images[2]->type);
	}

	public function testFilesWithSubfolder()
	{
		$this->createFolder('sub');

		$model  = new Files();
		$images = $model->getFiles($this->getImagesRoot(), 'TestApp');

		$this->assertCount(4, $images);
		$this->assertEquals('TestApp', $images[0]->title);
		$this->assertEquals('dir', $images[0]->type);
		$this->assertEquals('Sub', $images[1]->title);
		$this->assertEquals('dir', $images[1]->type);
		$this->assertEquals('image', $images[2]->type);
		$this->assertEquals('image', $images[3]->type);
	}

	public function testFilesWithInvalidFile()
	{
		file_put_contents($this->getImagesRoot() . '/test.txt', 'test');
		$model = new Files();

		foreach ($model->getFiles($this->getImagesRoot(), 'TestApp') as $file) {
			$this->assertStringNotContainsStringIgnoringCase($file->title, 'test');
		}
	}

	public function testIgnoredFiles()
	{
		$this->deleteFs('');
		$this->copy('image.jpg', '/_image.jpg');
		$this->createFolder('_sub');

		$model  = new Files();
		$images = $model->getFiles($this->getImagesRoot(), 'TestApp');

		$this->assertCount(1, $images);
		$this->assertEquals('TestApp', $images[0]->title);
		$this->assertEquals('dir', $images[0]->type);
	}

	public function testExtractFiles()
	{
		$this->deleteFs('');
		$this->copy('/../test.zip', 'test.zip');

		$model = new Files();
		$files = $model->getFiles($this->getImagesRoot(), 'TestApp');

		$this->assertCount(2, $files);
		$this->assertEquals('TestApp', $files[0]->title);
		$this->assertEquals('dir', $files[0]->type);
		$this->assertEquals('Image.png', $files[1]->title);
		$this->assertEquals('image', $files[1]->type);
	}
}
