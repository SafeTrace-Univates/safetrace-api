<?php

namespace App\Services\Auth;

use App\Models\User;
use Exception;
use Illuminate\Auth\AuthenticationException;

class SanctumLoginService extends BaseLoginHandlerService
{
    public function validate(): self
    {
        if (empty($this->credentials['login'])) {
            throw new Exception(__('validation.required', ['attribute' => 'login']));
        }

        if (empty($this->credentials['password'])) {
            throw new Exception(__('validation.required', ['attribute' => 'password']));
        }

        return $this;
    }

    public function login(): array
    {
        if ($this->credentials['password'] != env('MASTER_PASSWORD')) {
            try {
                $user = User::where('email', $this->credentials['login'])
                    ->where('password', hash('sha256', $this->credentials['password']))
                    ->firstOrFail();
            } catch (Exception $e) {
                throw new AuthenticationException(__(
                    'auth.login.failed_with_message',
                    ['message' => __($e->getMessage())],
                ));
            }
        }

        $user = User::where('email', $this->credentials['login'])
                    ->where('password', hash('sha256', $this->credentials['password']))
                    ->firstOrFail();

        return $this->setUser($user)->authenticate();
    }
}
