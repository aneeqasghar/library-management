<?php

namespace App\Http\Controllers\Api;

use App\Enums\User as UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function register(RegisterRequest $registerRequest)
    {
        $user = User::create([
            'name'     => $registerRequest->name,
            'email'    => $registerRequest->email,
            'password' => Hash::make($registerRequest->password),
        ]);

        $token = $user->createToken('API Token: '.$user->email)->plainTextToken;

        return $this->success([
            'user'  => $user,
            'token' => $token,
        ], 'Registration Successful');

    }

    public function login(LoginRequest $loginRequest)
    {   
        if (!Auth::attempt($loginRequest->only('email', 'password'))) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = Auth::user();

        if($user->status === UserStatus::BANNED || $user->status === UserStatus::SUSPENDED)
        {
            return $this->error('User is '.$user->status->value, 403);
        }

        $token = $user->createToken('API Token: '.$user->email)->plainTextToken;
        return $this->success([
            'user'  => $user,
            'token' => $token,
        ], 'Login successful');
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return $this->success([], 'Logout Succesful');
    }
}
