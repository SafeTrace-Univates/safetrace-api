<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ref_user'   => ['required', 'integer', 'exists:users,id'],
            'name'       => ['nullable', 'string'],
            'contacts'   => ['required', 'array'],
            'contacts.*' => ['integer', 'exists:contact,id'],
        ];
    }
}
