<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\System;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;

class SystemService extends Facade
{
    public System $system;

    public function __construct(System $system = null)
    {
        $this->system = $system ?? new System();
    }

    public static function make(System $system = null): self
    {
        return new self($system);
    }

    private function generateNegativeId(): int
    {
        $minId = System::min('id');
        return blank($minId) || $minId >= 0 ? -1 : $minId - 1;
    }

    private function generateToken(): string
    {
        return $this->system->user->createToken('auth_token')->plainTextToken;
    }

    public function create($data): self
    {
        return DB::transaction(function () use ($data) {
            $this->system = System::create([
                'id'   => $this->generateNegativeId(),
                'name' => $data['name'],
            ]);

            UserService::make()->sync();

            $token = $this->generateToken();

            $this->system->update(['token' => $token]);
            $this->system->user->syncRoles(RoleEnum::ADMIN->value);

            return $this;
        });
    }

    public function delete(): self
    {
        return DB::transaction(function () {
            $this->system->delete();

            UserService::make()->sync();

            return $this;
        });
    }
}
