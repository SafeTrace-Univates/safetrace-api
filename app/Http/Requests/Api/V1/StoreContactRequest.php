<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ref_owner' => 'required|integer|exists:users,id',
            'ref_user'  => 'required|integer|exists:users,id',
            'nickname'  => 'nullable|string|max:255',
        ];
    }
}
