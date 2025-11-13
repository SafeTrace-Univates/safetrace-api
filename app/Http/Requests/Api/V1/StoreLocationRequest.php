<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ref_alert' => ['required', 'integer', 'exists:alert,id'],
            'latitude'  => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ];
    }
}
