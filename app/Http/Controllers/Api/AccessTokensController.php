<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255|min:8',
            'device_name' => 'string|max:255',
            'abilities' => 'nullable|array',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $device_name = $request->post('device_name', $request->userAgent());
            $token = $user->createToken($device_name, $request->post('abilities'));

            return response()->json([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if ($token === null) {
            $user->currentAccessToken()->delete();

            return;
        }

        $personal_Access_Token = PersonalAccessToken::findToken($token);

        if (
            $user->id == $personal_Access_Token->tokenable_id
            && $personal_Access_Token->tokenable_type == get_class($user)
        ) {
            $personal_Access_Token->delete();

            return;
        }
    }
}
