<?php

namespace App\Http\Controllers;

use App\Helpers\AuthorizeMethod;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;

    final protected function authorizeMethods(array $methods)
    {
        collect($methods)->each(function (AuthorizeMethod $authMethod) {
            $this->middleware("can:{$authMethod->permission},{$authMethod->param}")
                 ->only($authMethod->method);
        });
    }
}
