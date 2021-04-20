<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http\Controllers\Auth;

use Sudu\Http\Controllers\Controller;
use Sudu\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	use AuthenticatesUsers;

	protected function authenticated(Request $request, User $user)
	{
		return response()->json($user);
	}

	protected function loggedOut(Request $request)
	{
		return response()->json();
	}
}
