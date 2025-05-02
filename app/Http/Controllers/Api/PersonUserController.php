<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PersonUserRequest;
use App\Models\Api\PersonUser;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class PersonUserController extends Controller
{
    public function index(Request $request)
    {
        $perPage   = $request->input('per_page', 10);
        $sortBy    = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = PersonUser::where('deleted', 0);

        if (!request()->user()?->is_master) {
            $query->where('id_credential', request('id_credential'));
        }

        $query->orderBy($sortBy, $sortOrder);
        $results = $query->paginate($perPage);

        return response()->json([
            'vínculos de usuários' => $results,
            'applied_filters' => [],
            'options' => [
                'sort_by'    => $sortBy,
                'sort_order' => $sortOrder,
                'per_page'   => $perPage,
            ],
        ]);
    }

    public function store(PersonUserRequest $request)
    {
        $data = $request->validated();
        $data['deleted'] = 0;

        if (!request()->user()?->is_master) {
            $data['id_credential'] = request('id_credential');
        } elseif ($request->has('id_credential')) {
            $data['id_credential'] = $request->input('id_credential');
        }

        return PersonUser::create($data);
    }

    public function show($id)
    {
        $record = PersonUser::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($record);

        return $record;
    }

    public function update(PersonUserRequest $request, $id)
    {
        $record = PersonUser::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($record);

        $data = $request->validated();
        $data['id_credential'] = $record->id_credential;

        $record->update($data);

        return $record;
    }

    public function destroy($id)
    {
        $record = PersonUser::where('id', $id)->where('deleted', 0)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($record);

        $record->update(['deleted' => 1]);

        return response()->json(['success' => true]);
    }
}
