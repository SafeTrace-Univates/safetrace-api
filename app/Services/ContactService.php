<?php

namespace App\Services;

use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Http\Requests\Api\V1\UpdateContactRequest;
use App\Models\Contact;
use App\Services\Validation\FormRequestFactory;
use Illuminate\Support\Facades\DB;

class ContactService
{
    public ?Contact $contact = null;

    public function __construct(?Contact $contact = null)
    {
        $this->contact = $contact ?? new Contact();
    }

    public static function make(?Contact $contact = null): self
    {
        return new self($contact);
    }

    public static function create(array $data): self
    {
        $data = FormRequestFactory::make(
            StoreContactRequest::class,
            $data,
        )->validated();

        $service = self::make();
        $service->contact->fill($data)->saveOrFail();

        return $service;
    }

    public function update(array $data): self
    {
        $data = FormRequestFactory::make(
            UpdateContactRequest::class,
            $data,
        )->validated();

        $this->contact->nickname = $data['nickname'];
        $this->contact->fill($data)->saveOrFail();

        return $this;
    }

    public function delete(): self
    {
        return DB::transaction(function () {
            $this->contact->delete();
            return $this;
        });
    }
}
