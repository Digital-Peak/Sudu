<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Models;

use Sudu\Archive\Packer;
use Sudu\Entity\Directory;
use Sudu\Entity\Image;

class Files
{
	public function getFiles(string $path, string $appName = null): array
	{
		// Extract zip archives first
		foreach (new \DirectoryIterator($path) as $file) {
			if ($file->getExtension() != 'zip') {
				continue;
			}

			(new Packer())->extract($file->getPathname());
			unlink($file->getPathname());
		}

		$data = [];
		foreach (new \DirectoryIterator($path) as $file) {
			// Ignore dot files or when they start with an underscore
			if ($file->isDot() || strpos($file->getFilename(), '_') === 0) {
				continue;
			}

			if (is_dir($file->getPathname())) {
				$data[] = new Directory($file->getPathname());
				continue;
			}

			if (!in_array(strtolower($file->getExtension()), ['jpg', 'png', 'webp'])) {
				continue;
			}

			$data[] = new Image($file->getPathname());
		}

		usort($data, function ($a, $b) {
			if ($a instanceof Image && $b instanceof Directory) {
				return 1;
			}
			if ($a instanceof Directory && $b instanceof Image) {
				return -1;
			}

			return strcmp($a->title, $b->title);
		});

		if (strpos(dirname($path), '/images') !== false) {
			$up        = new Directory(dirname($path));
			$up->title = '..';
			array_unshift($data, $up);
		}

		$main        = new Directory($path);
		$main->title = ($appName ?: config('app.name')) . ($main->path == '/' ? '' : ' - ' . $main->title);
		array_unshift($data, $main);

		return $data;
	}
}
