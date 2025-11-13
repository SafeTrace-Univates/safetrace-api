<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecordingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ref_alert' => ['required', 'integer', 'exists:alerts,id'],
            'file_path' => ['required', 'string'],
            'duration'  => ['required', 'integer', 'min:0'],
        ];
    }
}
