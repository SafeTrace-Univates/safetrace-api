<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreAlertRequest;
use App\Http\Requests\Api\V1\UpdateAlertRequest;
use App\Models\Alert;
use App\Services\Validation\FormRequestFactory;
use Illuminate\Support\Facades\DB;

class AlertService
{
    public ?Alert $alert = null;

    public function __construct(?Alert $alert = null)
    {
        $this->alert = $alert ?? new Alert();
    }

    public static function make(?Alert $alert = null): self
    {
        return new self($alert);
    }

    public static function create(array $data): self
    {
        $data = FormRequestFactory::make(
            StoreAlertRequest::class,
            $data,
        )->validated();

        $service = self::make();

        DB::transaction(function () use ($data, $service) {
            $service->alert->fill($data)->saveOrFail();

            if (isset($data['contacts'])) {
                $service->alert->contacts()->sync($data['contacts']);
            }
        });

        return $service;
    }

    public function update(array $data): self
    {
        $data = FormRequestFactory::make(
            UpdateAlertRequest::class,
            $data,
        )->validated();

        $this->alert->fill($data)->saveOrFail();

        return $this;
    }
}
