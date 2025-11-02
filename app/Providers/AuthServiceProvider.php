<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\System;
use App\Models\User;
use App\Policies\ContactPolicy;
use App\Policies\SystemPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class    => UserPolicy::class,
        System::class  => SystemPolicy::class,
        Contact::class => ContactPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
