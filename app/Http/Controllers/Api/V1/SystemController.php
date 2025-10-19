<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSystemRequest;
use App\Http\Resources\SystemResource;
use App\Models\System;
use App\Services\SystemService;
use Spatie\QueryBuilder\QueryBuilder;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(System::class, 'system');
    }

    public function index()
    {
        $systems = QueryBuilder::for(System::class)
            ->allowedFilters([
                'name',
            ])
            ->jsonPaginate();

        return SystemResource::collection($systems);
    }

    public function store(StoreSystemRequest $request)
    {
        return new SystemResource(
            SystemService::make()->create($request->validated())->system,
        );
    }

    public function show(System $system)
    {
        return new SystemResource($system);
    }

    public function destroy(System $system)
    {
        SystemService::make($system)->delete();
        return response()->noContent();
    }
}
