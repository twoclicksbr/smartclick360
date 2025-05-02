<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest as ApiLoginRequest;
use App\Models\Api\Token as ApiToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(ApiLoginRequest $request)
    {
        $user = \App\Models\Api\PersonUser::where('email', $request->email)
            ->where('active', 1)
            ->where('deleted', 0)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        $token = Str::random(64);
        $expiresAt = Carbon::now()->addHours(24);

        ApiToken::create([
            'id_credential' => $user->id_credential,
            'id_person'     => $user->id_person,
            'token'         => $token,
            'expires_at'    => $expiresAt,
        ]);

        return response()->json([
            'idCredential' => $user->id_credential,
            'username'     => $user->credential->username,
            'token'        => $token,
            'idPerson'     => $user->id_person,
            'name'         => $user->person->name,
        ]);
    }

    public function logout(Request $request)
    {
        $tokenHeader = $request->header('token');

        ApiToken::where('token', $tokenHeader)->delete();

        return response()->json(['success' => 'Logout realizado com sucesso.']);
    }
}
