<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
        ];
    }
}
