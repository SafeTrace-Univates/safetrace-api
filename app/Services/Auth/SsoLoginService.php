<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class SsoLoginService extends BaseLoginHandlerService
{
    public function validate(): self
    {
        if (empty($this->credentials['token'])) {
            throw new Exception(__('validation.required', ['attribute' => 'token']));
        }

        return $this;
    }

    public function login(): array
    {
        $jwt = $this->resolveJwt();

        $user = User::where('id', $jwt->login)->firstOrFail();

        return $this->setUser($user)->authenticate();
    }

    private function resolveJwt(): stdClass
    {
        $token = $this->credentials['token'];

        $key       = config('auth.sso.key');
        $algorithm = config('auth.sso.algorithm');

        return JWT::decode($token, new Key($key, $algorithm));
    }
}
