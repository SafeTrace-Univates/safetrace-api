<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class Setting extends Settings
{
    public array $admin_users     = [];
    public array $secretary_users = [];

    public static function group(): string
    {
        return 'setting';
    }
}
