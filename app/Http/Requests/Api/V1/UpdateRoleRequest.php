<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['sometimes', 'required', 'string', 'max:255', 'unique:roles'],
            'guard_name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
