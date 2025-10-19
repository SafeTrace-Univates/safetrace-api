<?php

namespace App\Services;

use App\Contracts\LoginHandlerContract;
use App\Services\Auth\SanctumLoginService;
use App\Services\Auth\SsoLoginService;

class AuthService
{
    private const LOGIN_HANDLER = [
        'sanctum' => SanctumLoginService::class,
        'sso'     => SsoLoginService::class,
    ];

    private LoginHandlerContract $loginHandler;

    public function __construct($credentials)
    {
        $handlerClass       = self::LOGIN_HANDLER[$credentials['driver']];
        $this->loginHandler = new $handlerClass($credentials);
    }

    public static function make($credentials): self
    {
        return new self($credentials);
    }

    public function handleLogin()
    {
        return $this->loginHandler->handleLogin();
    }
}
