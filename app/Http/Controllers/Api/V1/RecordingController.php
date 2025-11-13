<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRecordingRequest;
use App\Models\Recording;
use App\Services\RecordingService;
use Spatie\QueryBuilder\QueryBuilder;

class RecordingController extends Controller
{
    public function index()
    {
        $recording = QueryBuilder::for(Recording::class)
            ->allowedIncludes(['alert'])
            ->defaultSort('id')
            ->jsonPaginate();

        return $recording;
    }

    public function store(StoreRecordingRequest $request)
    {
        return RecordingService::make()->create($request->validated())->recording;
    }

    public function show(Recording $recording)
    {
        return QueryBuilder::for(Recording::where('id', $recording->id))
            ->allowedIncludes(['alert'])
            ->firstOrFail();
    }
}
