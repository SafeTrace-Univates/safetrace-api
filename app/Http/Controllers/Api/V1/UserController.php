<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Spatie\QueryBuilder\Filters\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\UserRoleRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Models\User;
use App\Services\UserService;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                'email',
                AllowedFilter::custom(
                    'search',
                    new SearchFilter([
                        'id',
                        'name',
                    ]),
                ),
            ])
            ->allowedIncludes([
                'roles',
            ])
            ->allowedSorts([
                'id',
                'name',
                'email',
            ])
            ->jsonPaginate();

        return UserResource::collection($users);
    }

    public function store()
    {
    }

    public function show(User $user)
    {
        $user = QueryBuilder::for(User::class)
            ->allowedIncludes(['roles'])
            ->findOrFail($user->id);

        return new UserResource($user);
    }

    public function syncRoles(UserRoleRequest $request, User $user)
    {
        UserService::make()->syncRoles(
            auth()->user(),
            $user,
            $request->roles,
        );

        return $user->load(['roles']);
    }
}
