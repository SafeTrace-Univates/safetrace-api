<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Requests\Api\V1\SetActiveRoleRequest;
use App\Http\Resources\AuthUserResouce;
use App\Models\User;
use App\Services\AuthService;
use App\Services\Roles\UserRoleSyncer;
use App\Services\RoleSyncerOrchestrator;
use App\Services\UserService;
use Auth;

class AuthController
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        return AuthService::make($credentials)->handleLogin();
    }

    public function user()
    {
        return new AuthUserResouce(Auth::user());
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        Auth::user()->unsetActiveRole();

        return ['message' => __('auth.logout.success')];
    }

    public function setActiveRole(SetActiveRoleRequest $request)
    {
        Auth::user()->setActiveRole($request->input('role'));
        return $this->user();
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = UserService::make(new User())->register($data);

        $credentials = [
            'driver'   => 'sanctum',
            'login'    => $data['email'],
            'password' => $data['password'],
        ];

        RoleSyncerOrchestrator::make([new UserRoleSyncer()])->syncRoles();

        return AuthService::make($credentials)->handleLogin();
    }
}
