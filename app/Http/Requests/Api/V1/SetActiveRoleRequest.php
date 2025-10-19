<?php

namespace App\Http\Requests\Api\V1;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SetActiveRoleRequest extends FormRequest
{
    public function rules(): array
    {
        $roles = Auth::user()->roles->pluck('name')->join(',');

        return [
            'role' => [
                'required',
                'exists:roles,name',
                "in:{$roles}",
            ],
        ];
    }
}
