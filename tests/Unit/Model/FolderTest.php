<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests\Unit\Model;

use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PHPUnit\Framework\TestCase;
use Sudu\Models\Folder;
use Sudu\Tests\FileOperations;

class FolderTest extends TestCase
{
	use FileOperations;

	public function testCreateFolder() {
		$model  = new Folder();
		$folder = $model->createFolder('test', $this->getImagesRoot());

		$this->assertEquals('Test', $folder->title);
		$this->assertEquals('dir', $folder->type);
		$this->assertEquals('/test', $folder->path);
	}

	public function testCreateFolderInvalidParent() {
		$this->expectException(FileNotFoundException::class);

		$model = new Folder();
		$model->createFolder('test', $this->getImagesRoot() . '/invalid');
	}

	public function testCreateFolderExistingLocation() {
		$this->expectException(FileExistsException::class);

		$this->createFolder('/existing');

		$model = new Folder();
		$model->createFolder('existing', $this->getImagesRoot());
	}
}
