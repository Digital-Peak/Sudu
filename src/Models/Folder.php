<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Models;

use Sudu\Entity\Directory;
use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class Folder
{
	public function createFolder(string $name, string $parent): Directory
	{
		if (!file_exists($parent)) {
			throw new FileNotFoundException('Parent not found', 500);
		}

		$path = $parent . '/' . $name;
		if (file_exists($path)) {
			throw new FileExistsException('File exists', 500);
		}

		mkdir($path);

		return new Directory($path);
	}
}
