<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

namespace Sudu\Http\Controllers\Api\V1;

use Sudu\Http\Controllers\Controller;
use Sudu\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
	public function get(string|int $id, User $model): JsonResponse
	{
		$user = Auth::user();
		if ($id != 'me') {
			$user = $model->where('id', $id)->first();
		}

		if (!$user) {
			throw new \InvalidArgumentException('User not found!!', 404);
		}

		return response()->json($user);
	}

	public function list(User $model): JsonResponse
	{
		return response()->json($model->all());
	}

	public function create(Request $request, User $user): JsonResponse
	{
		$request->validate(['name' => 'required', 'email' => 'required|email:rfc|unique:users', 'password' => 'required']);

		$user->name     = $request->input('name');
		$user->email    = $request->input('email');
		$user->password = bcrypt($request->input('password'));
		$user->save();

		return response()->json($user);
	}

	public function edit(string|int $id, Request $request, User $model): JsonResponse
	{
		$user = Auth::user();
		if ($id != 'me') {
			$user = $model->where('id', $id)->first();
		}

		if (!$user || !$user->id) {
			throw new \InvalidArgumentException('User not found!!', 404);
		}

		$request->validate(['name' => 'required', 'email' => 'required|email:rfc', 'password' => 'sometimes',]);

		$user->name  = $request->input('name');
		$user->email = $request->input('email');
		if ($request->input('password')) {
			$user->password = bcrypt($request->input('password'));
		}
		$user->save();

		return response()->json($user);
	}

	public function delete(int $id, User $model): JsonResponse
	{
		$user = $model->find($id);
		if (!$user || !$user->id) {
			throw new \InvalidArgumentException('User not found!!', 404);
		}

		$user->delete();

		return response()->json();
	}
}
