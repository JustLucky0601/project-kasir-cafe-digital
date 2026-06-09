<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends BaseApiController
{
    public function login(Request $request)
    {
        $v = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $v['username'])->first();
        if (!$user) {
            return $this->respond(false, 'Invalid credentials', [], 401);
        }

        if (!Auth::attempt(['username' => $v['username'], 'password' => $v['password']], false)) {
            return $this->respond(false, 'Invalid credentials', [], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Sanctum personal access token
        $token = $user->createToken('api-token-'.Str::random(8))->plainTextToken;

        return $this->respond(true, 'Login success', [
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'nama_lengkap' => $user->nama_lengkap,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // revoke current token
            $request->user()->currentAccessToken()?->delete();
        }

        return $this->respond(true, 'Logout success', []);
    }
}

