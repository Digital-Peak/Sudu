<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Unit\Entity;

use Sudu\Entity\Image;
use Sudu\Tests\FileOperations;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
	use FileOperations;

	public function testImagePng()
	{
		$image = new Image($this->getImagesRoot() . '/image.png');

		$this->assertNotEmpty('id', $image->id);
		$this->assertEquals('image', $image->type);
		$this->assertEquals('Image.png', $image->title);
		$this->assertEquals('/image.png', $image->path);
		$this->assertEquals('/_w' . Image::THUMBNAIL_SIZE . '/image.png', $image->thumbnail->path);
		$this->assertNotEmpty($image->data);
		$this->assertNotEmpty($image->data['size']);
		$this->assertNotEmpty($image->data['width']);
		$this->assertNotEmpty($image->data['height']);
		$this->assertNotEmpty($image->data['date']);
		$this->assertFileExists($this->getImagesRoot() . '/_w' . Image::THUMBNAIL_SIZE . '/image.png');
	}

	public function testImageJpg()
	{
		$image = new Image($this->getImagesRoot() . '/image.jpg');

		$this->assertNotEmpty('id', $image->id);
		$this->assertEquals('image', $image->type);
		$this->assertEquals('Image.jpg', $image->title);
		$this->assertEquals('/image.jpg', $image->path);
		$this->assertEquals('/_w' . Image::THUMBNAIL_SIZE . '/image.jpg', $image->thumbnail->path);
		$this->assertNotEmpty($image->data);
		$this->assertNotEmpty($image->data['size']);
		$this->assertNotEmpty($image->data['width']);
		$this->assertNotEmpty($image->data['height']);
		$this->assertNotEmpty($image->data['date']);
		$this->assertFileExists($this->getImagesRoot() . '/_w' . Image::THUMBNAIL_SIZE . '/image.jpg');
	}
}
