<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Tests;

use Illuminate\Filesystem\Filesystem;

/**
 * Trait for file operations within a temporary space
 */
trait FileOperations
{
	private $root;

	public function setUp(): void {
		$this->root = __DIR__;

		$fs = new Filesystem();
		$fs->deleteDirectory($this->getRoot());
		$fs->makeDirectory($this->getRoot());

		$fs->copyDirectory($this->root . '/data', $this->getRoot());

		parent::setUp();
	}

	/**
	 * Returns the root of the temporary space.
	 *
	 * @return string
	 */
	protected function getRoot(): string {
		return $this->root . '/tmp';
	}

	public function tearDown(): void {
		parent::tearDown();

		(new Filesystem())->deleteDirectory($this->getRoot());
	}

	/**
	 * Returns the project root.
	 *
	 * @return string
	 */
	protected function getProjectRoot(): string {
		return dirname($this->root);
	}

	/**
	 * Creates a folder within the temporary image space.
	 *
	 * @param string $name
	 *
	 * @see getImagesRoot()
	 */
	protected function createFolder(string $name) {
		(new Filesystem())->makeDirectory($this->getImagesRoot() . '/' . $name);
	}

	/**
	 * Returns the images folder within the temporary space.
	 *
	 * @return string
	 */
	protected function getImagesRoot(): string {
		return $this->getRoot() . '/images';
	}

	/**
	 * Copies a file or folder to the destination. If the source doesn't exist it will be assumed from
	 * the data folder within the tests folder. If the destination doesn't exist it will be copied to
	 * the temporary image space.
	 *
	 * @param string $source
	 * @param string $destination
	 *
	 * @see getImagesRoot()
	 */
	protected function copy(string $source, string $destination) {
		$parent = dirname($this->getImagesRoot() . '/' . $destination);

		$fs = new Filesystem();
		if (!$fs->isDirectory($parent)) {
			$fs->makeDirectory($parent, 0755, true);
		}

		if (!file_exists($source)) {
			$source = $this->root . '/data/images/' . $source;
		}

		if (!file_exists($destination)) {
			$destination = $this->getImagesRoot() . '/' . $destination;
		}

		if ($fs->isDirectory($source)) {
			$fs->copyDirectory($source, $destination);

			return;
		}

		$fs->copy($source, $destination);
	}


	/**
	 * Deletes a file or folder within the temporary image space.
	 *
	 * @param string $path
	 *
	 * @see getImagesRoot()
	 */
	protected function deleteFs($path) {
		$fullPath = $this->getImagesRoot() . '/' . $path;

		$fs = new Filesystem();
		if ($fs->isDirectory($fullPath)) {
			$fs->deleteDirectory($fullPath);

			return;
		}

		$fs->delete($path);
	}
}
