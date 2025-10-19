<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;

class DevController extends Controller
{
    public function jwtToken(string $userId)
    {
        $jwt = JWT::encode(
            [
                'login' => $userId,
                'exp'   => now()->addMinutes(10)->timestamp,
            ],
            config('auth.sso.key'),
            config('auth.sso.algorithm'),
        );

        return ['jwt' => $jwt];
    }
}
