<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokenService
{
    public function createToken($data, $user_agent)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return null;
        }

        $deviceName = $data['device_name'] ?? $user_agent;

        $token = $user->createToken(
            $deviceName,
            $data['abilities'] ?? ['*']
        );

        return [
            'token' => $token->plainTextToken,
            'user' => $user,
        ];
    }
    public function revokeCurrentToken($user): void
    {
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }
    }
    public function revokeTokenByString($user, string $tokenString): bool
    {
        $accessToken = PersonalAccessToken::findToken($tokenString);

        if (! $accessToken) {
            return false;
        }

        $isOwner =
            $accessToken->tokenable_id === $user->id &&
            $accessToken->tokenable_type === get_class($user);

        if (! $isOwner) {
            return false;
        }

        $accessToken->delete();

        return true;
    }
}
