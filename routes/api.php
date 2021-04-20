<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

use Illuminate\Support\Facades\Route;

// Files routes
Route::post('v1/files/archive', [\Sudu\Http\Controllers\Api\V1\FilesController::class, 'download']);

Route::post('v1/files/images/{path?}', [\Sudu\Http\Controllers\Api\V1\FilesController::class, 'createImage'])
	->where('path', '.+')
	->middleware('auth');
Route::delete('v1/files/images/{path?}', [\Sudu\Http\Controllers\Api\V1\FilesController::class, 'deleteImages'])
	->where('path', '.+')
	->middleware('auth');

Route::post('v1/files/folder/{path}', [\Sudu\Http\Controllers\Api\V1\FilesController::class, 'createFolder'])
	->where('path', '.+')
	->middleware('auth');

Route::get('v1/files/{path?}', [\Sudu\Http\Controllers\Api\V1\FilesController::class, 'list'])
	->where('path', '.+');

// User routes
Route::post('v1/user/login', [\Sudu\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('v1/user/logout', [\Sudu\Http\Controllers\Auth\LoginController::class, 'logout'])
	->middleware('auth');
Route::get('v1/users/{id}', [\Sudu\Http\Controllers\Api\V1\UsersController::class, 'get'])
	->middleware('auth');
Route::get('v1/users', [\Sudu\Http\Controllers\Api\V1\UsersController::class, 'list'])
	->middleware('auth');
Route::post('v1/users', [\Sudu\Http\Controllers\Api\V1\UsersController::class, 'create'])
	->middleware('auth');
Route::put('v1/users/{id}', [\Sudu\Http\Controllers\Api\V1\UsersController::class, 'edit'])
	->middleware('auth');
Route::delete('v1/users/{id}', [\Sudu\Http\Controllers\Api\V1\UsersController::class, 'delete'])
	->middleware('auth');
