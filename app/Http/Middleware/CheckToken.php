<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Api\Token;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        $tokenHeader = $request->header('token');

        if (!$tokenHeader) {
            return response()->json(['error' => 'Token não informado.'], 401);
        }

        $token = Token::where('token', $tokenHeader)
            ->where('expires_at', '>', now())
            ->first();

        if (!$token || !$token->credential || !$token->credential->active) {
            return response()->json(['error' => 'Token inválido ou expirado.'], 401);
        }

        // Injetar dados na request
        $request->merge([
            'id_credential' => $token->id_credential,
            'id_person'     => $token->id_person,
        ]);

        // Permitir usar request()->user()
        $request->setUserResolver(fn() => $token->credential);

        return $next($request);
    }
}
