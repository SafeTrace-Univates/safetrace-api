<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreRecordingRequest;
use App\Models\Recording;
use App\Services\Validation\FormRequestFactory;

class RecordingService
{
    public ?Recording $recording = null;

    public function __construct(?Recording $recording = null)
    {
        $this->recording = $recording ?? new Recording();
    }

    public static function make(?Recording $recording = null): self
    {
        return new self($recording);
    }

    public static function create(array $data): self
    {
        $data = FormRequestFactory::make(
            StoreRecordingRequest::class,
            $data,
        )->validated();

        $service = self::make();
        $service->recording->fill($data)->saveOrFail();

        return $service;
    }
}
