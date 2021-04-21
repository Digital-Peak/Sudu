<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Archive;

use ZipArchive;

class Packer
{
	public function extract(string $path, $destination = null) {
		if (!file_exists($path)) {
			return;
		}

		$zip = new ZipArchive();
		$zip->open($path);
		$zip->extractTo($destination ?: dirname($path));
		$zip->close();
	}

	public function createZip(array $images, $baseDir = null) {
		$baseDir     = $baseDir ?: config('app.images_folder');
		$archivesDir = dirname($baseDir) . '/archives';

		set_time_limit(60 * 10);

		if (!is_dir($archivesDir)) {
			mkdir($archivesDir);
		}

		$fileName = $archivesDir . '/' . md5(serialize($images)) . '.zip';
		if (!file_exists($fileName)) {
			$zip = new ZipArchive();
			$zip->open($fileName, ZipArchive::CREATE);

			foreach ($images as $image) {
				$imagePath = str_replace('images/', '/', $image);
				$path      = realpath($baseDir . '/' . $imagePath);
				if (!$path || strpos($path, $baseDir) !== 0 || strpos($path, $baseDir) === false) {
					continue;
				}

				$zip->addFile($path, $imagePath);
			}
			$zip->close();
		}

		if (!file_exists($fileName)) {
			return null;
		}

		return $fileName;
	}
}
