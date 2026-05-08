<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAccessToken;
use App\Services\AccessTokenService;
use Illuminate\Support\Facades\Auth;

class AccessTokensController extends Controller
{
    public function __construct(protected AccessTokenService $accessTokenService) {}

    public function store(StoreAccessToken $request)
    {
        $data = $request->validated();

        $userAgent = $request->userAgent();

        $result = $this->accessTokenService->createToken(
            $data,
            $userAgent
        );

        if (! $result) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($result, 201);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if ($token === null) {
            $this->accessTokenService->revokeCurrentToken($user);

            return response()->noContent();
        }

        $deleted = $this->accessTokenService->revokeTokenByString($user, $token);

        if (! $deleted) {
            return response()->json(['message' => 'Token not found'], 404);
        }

        return response()->noContent();
    }
}
