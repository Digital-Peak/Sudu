<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Unit\Archive;

use PHPUnit\Framework\TestCase;
use Sudu\Archive\Packer;
use Sudu\Tests\FileOperations;

class PackerTest extends TestCase
{
	use FileOperations;

	public function testArchiveValidFiles() {
		$packer   = new Packer();
		$fileName = $packer->createZip(['images/image.png'], $this->getImagesRoot());

		$this->assertStringContainsString(realpath($this->getImagesRoot() . '/../archives'), $fileName);
		$this->assertFileExists($fileName);
	}

	public function testArchiveInvalidFiles() {
		$packer   = new Packer();
		$fileName = $packer->createZip(['images/image-invalid.png'], $this->getImagesRoot());

		$this->assertEmpty($fileName);
	}

	public function testExtractValidFile() {
		$packer = new Packer();
		$packer->extract($this->getRoot() . '/test.zip', $this->getImagesRoot());

		$this->assertFileExists($this->getImagesRoot() . '/image.png');
	}

	public function testExtractInvalidFile() {
		$this->deleteFs('');

		$packer = new Packer();
		$packer->extract($this->getRoot() . '/test-invalid.zip', $this->getImagesRoot());

		$this->assertFileDoesNotExist($this->getImagesRoot() . '/image.png');
	}
}
