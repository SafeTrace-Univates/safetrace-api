<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Spatie\QueryBuilder\Filters\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAlertRequest;
use App\Http\Requests\Api\V1\UpdateAlertRequest;
use App\Models\Alert;
use App\Services\AlertService;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = QueryBuilder::for(Alert::class)
            ->where('ref_user', Auth::id())
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('ref_user'),
                AllowedFilter::custom(
                    'search',
                    new SearchFilter(['id', 'ref_user', 'name']),
                ),
            ])
            ->allowedIncludes([
                'user',
                'contacts',
                'locations',
                'recordings',
            ])
            ->defaultSort('id')
            ->jsonPaginate();

        return $alerts;
    }

    public function store(StoreAlertRequest $request)
    {
        return AlertService::make()->create($request->validated())->alert;
    }

    public function show(Alert $alert)
    {
        $alert = QueryBuilder::for(Alert::where('id', $alert->id))
            ->allowedIncludes([
                'user',
                'contacts',
                'locations',
                'recordings',
            ])
            ->firstOrFail();
        return $alert;
    }

    public function update(UpdateAlertRequest $request, Alert $alert)
    {
        return AlertService::make($alert)->update($request->validated())->alert;
    }
}
