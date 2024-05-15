<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Request;

class CommonHelper
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public static function getUrlFromRequest(Request $request): string
    {
        return $request->headers->get('Origin');
    }

    /**
     * @throws \Exception
     */
    public static function randomNumberCode($length): string
    {
        $max = 10 ** $length - 1;
        $key = random_int(0, $max);
        return str_pad($key, $length, 0, STR_PAD_LEFT);
    }

    public static function removeNullValue($data): array
    {
        return array_filter($data, fn($value) => !is_null($value));
    }

    public static function getCurrentUser(): bool|\Illuminate\Contracts\Auth\Authenticatable
    {
        $user = auth()->user();

        if (is_null($user)) {
            return false;
        }

        return $user;
    }
}
