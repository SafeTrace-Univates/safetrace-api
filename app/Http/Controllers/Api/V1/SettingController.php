<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AuthorizeMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SettingRequest;
use App\Settings\Setting;
use DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->authorizeMethods([
            new AuthorizeMethod('config', Setting::class),
        ]);
    }

    public function config(SettingRequest $request, Setting $setting)
    {
        return DB::transaction(function () use ($request, $setting) {
            $attributeName = $request->get('name');

            $setting->$attributeName = $request->get('payload');
            $setting->save();

            return $setting->toArray();
        });
    }
}
