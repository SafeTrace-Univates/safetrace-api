<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreLocationRequest;
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

        return $locations;
    }

    public function store(StoreLocationRequest $request)
    {
        return LocationService::make()->create($request->validated())->location;
    }

    public function show(Location $location)
    {
        return QueryBuilder::for(Location::where('id', $location->id))
            ->allowedIncludes(['alert'])
            ->firstOrFail();
    }
}
