<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

use Illuminate\Support\Facades\Route;

Route::get('{any}_manifest', function () {
	return view('manifest');
})->where('any', '.*');

Route::get('{any}', function () {
	return view('app');
})->where('any', '.*');
