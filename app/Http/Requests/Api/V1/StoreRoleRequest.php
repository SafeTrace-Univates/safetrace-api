<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255', 'unique:roles'],
            'guard_name' => ['required', 'string', 'max:255'],
        ];
    }
}
