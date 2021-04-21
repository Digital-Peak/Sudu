<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sudu\Archive\Packer;
use Sudu\Http\Controllers\Controller;
use Sudu\Models\Files;
use Sudu\Models\Folder;
use Sudu\Models\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FilesController extends Controller
{
	public function createFolder(string $folderPath, Folder $model): JsonResponse {
		$path = $this->checkPath(dirname($folderPath));

		return response()->json($model->createFolder(basename($folderPath), $path));
	}

	private function checkPath(?string $path): string {
		$baseDir = config('app.images_folder');
		if (!is_dir($baseDir)) {
			mkdir($baseDir);
		}

		$baseDir  = realpath($baseDir);
		$realPath = empty($path) ? $baseDir : realpath($baseDir . '/' . trim($path, '/'));

		if (strpos($realPath, $baseDir) !== 0 || strpos($realPath, $baseDir) === false) {
			throw new NotFoundHttpException(
				!config('app.debug') ? 'Not found' : 'Path ' . $path . ' not found on ' . $baseDir,
				null,
				404
			);
		}

		return $realPath;
	}

	public function createImage(string $imagePath, Request $request, Image $model): JsonResponse {
		$path = $this->checkPath(dirname($imagePath));

		return response()->json($model->createImage($request->file('file'), $path));
	}

	public function deleteImages(Request $request, Image $model, Files $filesModel, string $path = null): JsonResponse {
		$images = [];
		foreach ($request->input('images') as $image) {
			$images[] = $this->checkPath($image);
		}

		$model->deleteImages($images);

		return $this->list($filesModel, $path);
	}

	public function list(Files $model, string $path = null): JsonResponse {
		$path = $this->checkPath($path);

		if (!is_dir($path)) {
			$path = dirname($path);
		}

		set_time_limit(60 * 10);

		return response()->json($model->getFiles($path));
	}

	public function download(Request $request, Packer $packer): JsonResponse {
		$file = $packer->createZip($request->input('images'));

		return response()->json(['file' => str_replace(dirname(config('app.images_folder')), '', $file)]);
	}
}
