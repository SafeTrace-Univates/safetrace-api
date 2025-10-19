<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public const DRIVERS = [
        'sanctum',
        'sso',
    ];

    public function prepareForValidation(): void
    {
        $this->merge([
            'driver' => $this->input('driver', 'sanctum'),
        ]);
    }

    public function rules(): array
    {
        $driver = $this->input('driver', 'sanctum');

        return match($driver) {
            'sso'   => $this->ssoRules(),
            default => $this->sanctumRules(),
        };
    }

    private function ssoRules()
    {
        return [
            'token'  => ['required', 'string'],
            'driver' => $this->getDriverRules(),
        ];
    }

    private function sanctumRules()
    {
        return [
            'login'       => ['required', 'string'],
            'password'    => ['required', 'string'],
            'remember_me' => ['boolean'],
            'driver'      => $this->getDriverRules(),
        ];
    }

    private function getDriverRules(): array
    {
        return [
            'in:' . collect(self::DRIVERS)->join(','),
        ];
    }
}
