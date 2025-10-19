<?php

namespace App\Http\Requests\Api\V1;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        if ($this->filled('phone')) {
            $rule = new PhoneNumber();

            $rule->validate('phone', $this->input('phone'), function () {});
            $this->merge([
                'phone' => $rule->getFormatted(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['phone_number'],
            'document' => ['required', 'string', 'unique:users,document'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
        ];
    }
}
