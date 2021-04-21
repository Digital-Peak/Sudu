<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Entity;

use DateTime;
use Gumlet\ImageResize;
use stdClass;

class Image
{
	/** @var int */
	const THUMBNAIL_SIZE = 450;

	/** @var string */
	public $id;

	/** @var string */
	public $title;

	/** @var string */
	public $path;

	/** @var stdClass */
	public $thumbnail;

	/** @var array */
	public $data;

	/** @var string */
	public $type = 'image';

	public function __construct($path) {
		$this->title     = str_replace(['-', '_'], ' ', ucfirst(basename($path)));
		$this->data      = $this->createData($path);
		$this->path      = $this->createWebPath($path);
		$this->id        = md5($this->path);
		$this->thumbnail = $this->createThumbnail($path);
	}

	private function createData(string $path): array {
		$data = ['width' => 0, 'height' => 0, 'size' => filesize($path)];
		$exif = @exif_read_data($path);

		if (!empty($exif['DateTimeOriginal'])) {
			$data['date'] = DateTime::createFromFormat('Y:m:d H:i:s', $exif['DateTimeOriginal'])->format('c');
		} else {
			$data['date'] = date('c', filemtime($path));
		}

		if (!empty($exif['COMPUTED']) && !empty($exif['COMPUTED']['Width'])) {
			$data['width'] = $exif['COMPUTED']['Width'];
		}
		if (!empty($exif['COMPUTED']) && !empty($exif['COMPUTED']['Height'])) {
			$data['height'] = $exif['COMPUTED']['Height'];
		}

		if (empty($data['width'])) {
			$size = getimagesize($path);

			if (!empty($size[0])) {
				$data['width']  = $size[0];
				$data['height'] = $size[1];
			}
		}

		return $data;
	}

	private function createWebPath(string $path): string {
		return substr($path, strpos($path, '/images/') + 7);
	}

	private function createThumbnail(string $path): stdClass {
		$image     = null;
		$thumbnail = new stdClass();

		$directory       = dirname($path) . '/_w' . self::THUMBNAIL_SIZE;
		$thumbnail->path = $this->createWebPath($directory . '/' . basename($path));

		if (!is_dir($directory)) {
			mkdir($directory);
		}

		if (!file_exists($directory . '/' . basename($path))) {
			$image = new ImageResize($path);
			$image->resizeToWidth(self::THUMBNAIL_SIZE);
			$image->save($directory . '/' . basename($path));

			if (!empty($this->data['date'])) {
				$timestamp = strtotime($this->data['date']);
				touch($path, $timestamp);
				touch($directory . '/' . basename($path), $timestamp);
			}
		}

		return $thumbnail;
	}
}
