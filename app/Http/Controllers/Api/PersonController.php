<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PersonRequest;
use App\Models\Api\Person;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $perPage   = $request->input('per_page', 10);
        $sortBy    = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = Person::where('deleted', 0);

        if (!request()->user()?->is_master) {
            $query->where('id_credential', request('id_credential'));
        }

        $query->orderBy($sortBy, $sortOrder);
        $results = $query->paginate($perPage);

        return response()->json([
            'pessoas' => $results,
            'applied_filters' => [],
            'options' => [
                'sort_by'    => $sortBy,
                'sort_order' => $sortOrder,
                'per_page'   => $perPage,
            ],
        ]);
    }

    public function store(PersonRequest $request)
    {
        $data = $request->validated();
        $data['deleted'] = 0;

        if (!request()->user()?->is_master) {
            $data['id_credential'] = request('id_credential');
        } elseif ($request->has('id_credential')) {
            $data['id_credential'] = $request->input('id_credential');
        }

        return Person::create($data);
    }

    public function show($id)
    {
        $person = Person::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($person);

        return $person;
    }

    public function update(PersonRequest $request, $id)
    {
        $person = Person::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($person);

        $data = $request->validated();

        // sempre mantém o id_credential original
        $data['id_credential'] = $person->id_credential;

        $person->update($data);

        return $person;
    }

    public function destroy($id)
    {
        $person = Person::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($person);

        $person->update(['deleted' => 1]);

        return response()->json(['success' => true]);
    }
}
