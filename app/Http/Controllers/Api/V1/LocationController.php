<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreLocationRequest;
use App\Http\Resources\Api\V1\LocationResource;
use App\Models\Location;
use App\Services\LocationService;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LocationController extends Controller
{
    public function index()
    {
        $locations = QueryBuilder::for(Location::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('ref_alert'),
            ])
            ->allowedIncludes(['alert'])
            ->defaultSort('id')
            ->jsonPaginate();

        return LocationResource::collection($locations);
    }

    public function store(StoreLocationRequest $request)
    {
        return new LocationResource(LocationService::make()->create($request->validated())->location);
    }

    public function show(Location $location)
    {

        $location = QueryBuilder::for(Location::where('id', $location->id))
            ->allowedIncludes(['alert'])
            ->firstOrFail();
        return new LocationResource($location);
    }
}
