<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreRecordingRequest;
use App\Http\Resources\Api\V1\RecordingResource;
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

        return RecordingResource::collection($recording);
    }

    public function store(StoreRecordingRequest $request)
    {
        return new RecordingResource(RecordingService::make()->create($request->validated())->recording);
    }

    public function show(Recording $recording)
    {
        $record = QueryBuilder::for(Recording::where('id', $recording->id))
            ->allowedIncludes(['alert'])
            ->firstOrFail();
        return new RecordingResource($record);
    }
}
