<?php

namespace App\Http\Middleware;

use App\Enums\ErrorTypeEnum;
use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWTToken
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user) {
                return $this->sendError(__('auth.user_invalid'), null, Response::HTTP_UNAUTHORIZED, [
                    'error_type' => 'Authenticate'
                ]);
            }
        }  catch (TokenInvalidException|TokenBlacklistedException $e) {
            return $this->sendError(__('auth.token_invalid'), null, Response::HTTP_UNAUTHORIZED);
        } catch (TokenExpiredException $e) {
            return $this->sendError(__('auth.token_expired'), null, Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return $this->sendError(__('auth.token_not_found'), null, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
