<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TokenRequest;
use App\Models\Api\Token;
use Illuminate\Http\Request;
use App\Helpers\AuthHelper;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        $perPage   = $request->input('per_page', 10);
        $sortBy    = $request->input('sort_by', 'id');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = Token::query();

        if (!request()->user()?->is_master) {
            $query->where('id_credential', request('id_credential'));
        }

        $query->orderBy($sortBy, $sortOrder);
        $results = $query->paginate($perPage);

        return response()->json([
            'tokens' => $results,
            'applied_filters' => [],
            'options' => [
                'sort_by'    => $sortBy,
                'sort_order' => $sortOrder,
                'per_page'   => $perPage,
            ],
        ]);
    }

    public function store(TokenRequest $request)
    {
        $data = $request->validated();

        if (!request()->user()?->is_master) {
            $data['id_credential'] = request('id_credential');
        } elseif ($request->has('id_credential')) {
            $data['id_credential'] = $request->input('id_credential');
        }

        return Token::create($data);
    }

    public function show($id)
    {
        $token = Token::where('id', $id)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($token);

        return $token;
    }

    public function update(TokenRequest $request, $id)
    {
        $token = Token::where('id', $id)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($token);

        $data = $request->validated();
        $data['id_credential'] = $token->id_credential;

        $token->update($data);

        return $token;
    }

    public function destroy($id)
    {
        $token = Token::where('id', $id)->firstOrFail();

        AuthHelper::denyIfNotOwnerOrMaster($token);

        $token->delete();

        return response()->json(['success' => true]);
    }
}
