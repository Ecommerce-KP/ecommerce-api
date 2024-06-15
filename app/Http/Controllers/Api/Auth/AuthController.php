<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $credentials = $request->validationData();
        if (!$token = auth()->setTTL(120)->attempt($credentials)) {
            return $this->sendError(__('auth.user_invalid'), Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();

        return $this->sendResponse(null, null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $token
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function respondWithToken($token): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $data =[
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 120
        ];

        return $this->sendResponse($data);
    }

    /**
     * Refresh a token.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function refresh(): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            return $this->respondWithToken(auth('api')->refresh());
        } catch (\Exception $e) {
            Log::debug("Refresh token: " . $e->getMessage());
            return $this->sendError(__('auth.unable_refresh_token'), Response::HTTP_UNAUTHORIZED);
        }
    }
}
