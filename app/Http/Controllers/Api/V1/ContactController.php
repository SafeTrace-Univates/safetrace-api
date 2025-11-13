<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Spatie\QueryBuilder\Filters\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreContactRequest;
use App\Http\Requests\Api\V1\UpdateContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = QueryBuilder::for(Contact::class)
            ->where('ref_owner', Auth::id())
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('ref_owner'),
                AllowedFilter::exact('ref_user'),
                AllowedFilter::custom(
                    'search',
                    new SearchFilter(['id', 'ref_user', 'nickname','user.name']),
                ),
            ])
            ->allowedIncludes(['owner', 'user'])
            ->defaultSort('id')
            ->jsonPaginate();

        return $contacts;
    }

    public function store(StoreContactRequest $request)
    {
        return ContactService::create($request->validated())->contact;
    }

    public function show(Contact $contact)
    {
        $contact = QueryBuilder::for(Contact::where('id', $contact->id))
            ->allowedIncludes(['owner', 'user'])
            ->firstOrFail();
        return $contact;
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        return ContactService::make($contact)->update($request->validated())->contact;
    }

    public function destroy(Contact $contact)
    {
        ContactService::make($contact)->delete();
        return response()->noContent();
    }
}
