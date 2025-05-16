<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Verifica se a sessão está válida
        if (!session('auth_idCredential') || !session('auth_token') || !session('auth_idPerson')) {
            return redirect()->route('auth.login')->with([
                'error_title' => 'Acesso restrito',
                'error_message' => 'Você precisa estar logado para acessar esta área.'
            ]);
        }

        if (session('locked')) {
            return redirect()->route('auth.lock.screen')->withErrors(['error' => 'Sessão bloqueada. Informe sua senha.']);
        }

        // 2. Se for uma rota de proxy para API externa (ex: /sys/api/...)
        if ($request->is('sys/api/*')) {
            $apiPath = str_replace('sys/api/', '', $request->path());

            $http = Http::withHeaders([
                'token' => session('auth_token')
            ]);

            // Desativa verificação SSL apenas em ambiente local
            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            $response = $http->send(
                $request->method(),
                env('APP_URL_API') . '/' . $apiPath,
                [
                    'query' => $request->query(),
                    'json' => $request->all(),
                ]
            );

            return response()->json($response->json(), $response->status());
        }

        // 3. Continua a execução normal
        return $next($request);
    }
}
