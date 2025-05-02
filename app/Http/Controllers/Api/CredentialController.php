<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CredentialRequest;
use App\Models\Api\Credential;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CredentialController extends Controller
{
    private function onlyMaster()
    {
        if (!request()->user()?->is_master) {
            abort(403, 'Acesso restrito ao administrador.');
        }
    }
    public function index(Request $request)
    {
        $this->onlyMaster();

        $perPage = $request->input('per_page', 10);
        $sortBy = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = Credential::where('deleted', 0)
            ->orderBy($sortBy, $sortOrder);

        $results = $query->paginate($perPage);

        return response()->json([
            'credential' => $results,
            'applied_filters' => [], // depois podemos montar isso dinamicamente
            'options' => [
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
                'per_page' => $perPage,
            ],
        ]);
    }


    public function store(CredentialRequest $request)
    {
        $this->onlyMaster();

        $data = $request->validated();
        $data['deleted'] = 0;

        return Credential::create($data);
    }

    public function show($id)
    {
        $this->onlyMaster();

        return Credential::where('id', $id)->where('deleted', 0)->firstOrFail();
    }

    public function update(CredentialRequest $request, $id)
    {
        $this->onlyMaster();

        $credential = Credential::where('id', $id)->where('deleted', 0)->firstOrFail();
        $credential->update($request->validated());

        return $credential;
    }

    public function destroy($id)
    {
        $this->onlyMaster();

        $credential = Credential::where('id', $id)->where('deleted', 0)->firstOrFail();
        $credential->update(['deleted' => 1]);

        return response()->json(['success' => true]);
    }
}
