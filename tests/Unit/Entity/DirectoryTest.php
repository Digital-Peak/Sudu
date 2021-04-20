<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Unit\Entity;

use Sudu\Entity\Directory;
use Sudu\Tests\FileOperations;
use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
	use FileOperations;

	public function testDirectory()
	{
		$directory = new Directory(__DIR__);

		$this->assertEquals('dir', $directory->type);
		$this->assertEquals('Entity', $directory->title);
		$this->assertEquals(__DIR__, $directory->path);
	}

	public function testDirectoryImages()
	{
		$directory = new Directory($this->getImagesRoot());

		$this->assertEquals('dir', $directory->type);
		$this->assertEquals('Images', $directory->title);
		$this->assertEquals('/', $directory->path);
	}
}
