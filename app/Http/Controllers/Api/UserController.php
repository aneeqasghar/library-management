<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponses;

    public function show(Request $request) {
        return $this->success($request->user(), 'User profile retrieved');
    }

    public function update(UpdateUserRequest $request) {
        $user = $request->user();
        $validated = $request->validated();

        if (isset($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return $this->success($user, 'User profile updated');
    }

    public function destroy(Request $request) {
        $user = $request->user();
        $user->delete();
        $user->tokens()->delete();
        return $this->success([], 'User deleted');
    }
}
