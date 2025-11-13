<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreLocationRequest;
use App\Models\Location;
use App\Services\Validation\FormRequestFactory;

class LocationService
{
    public ?Location $location = null;

    public function __construct(?Location $location = null)
    {
        $this->location = $location ?? new Location();
    }

    public static function make(?Location $location = null): self
    {
        return new self($location);
    }

    public static function create(array $data): self
    {
        $data = FormRequestFactory::make(
            StoreLocationRequest::class,
            $data,
        )->validated();

        $service = self::make();
        $service->location->fill($data)->saveOrFail();

        return $service;
    }
}
