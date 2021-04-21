<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

class Image
{
	public function deleteImages(array $images): void {
		$filesystem = new Filesystem();
		foreach ($images as $image) {
			$filesystem->delete($image);
		}
	}

	public function createImage(UploadedFile $image, string $parent): \Sudu\Entity\Image {
		if (!file_exists($parent)) {
			throw new FileNotFoundException('Parent not found', 500);
		}

		(new Filesystem())->copy($image->path(), $parent . '/' . $image->getClientOriginalName());

		return new \Sudu\Entity\Image($parent . '/' . $image->getClientOriginalName());
	}
}
