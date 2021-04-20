<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Entity;

class Directory
{
	/** @var string */
	public $title;

	/** @var string */
	public $path;

	/** @var string */
	public $type = 'dir';

	public function __construct(string $path)
	{
		$this->title = str_replace(['-', '_'], ' ', ucfirst(basename($path)));
		$this->path  = rtrim($path, '/');

		if ($pos = strpos($this->path, '/images')) {
			$this->path = substr($this->path, $pos + 7);
		}

		if (!$this->path) {
			$this->path = '/';
		}

		// Normalize
		$this->path = str_replace('//', '/', $this->path);
	}
}
