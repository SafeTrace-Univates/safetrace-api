<?php

namespace App\Providers;

use App\Models\System;
use App\Models\User;
use App\Models\Contact;
use App\Policies\SystemPolicy;
use App\Policies\UserPolicy;
use App\Policies\ContactPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class   => UserPolicy::class,
        System::class => SystemPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
