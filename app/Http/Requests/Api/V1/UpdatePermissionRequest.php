<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePermissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['sometimes', 'required', 'string', 'max:255', 'unique:permissions,name'],
            'guard_name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }
}
