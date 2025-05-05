<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        // if (!session('idCredential') || !session('token') || !session('idPerson')) {
        //     // return redirect()->route('login')->with('error', 'Você precisa estar logado');
        //     // return redirect()->route('auth.login')->with('error', 'Você precisa estar logado.');

        //     return redirect()->route('auth.login')->withErrors([
        //         'login' => 'Você precisa estar logado.',
        //     ]);
        // }

        if (!session('idCredential') || !session('token') || !session('idPerson')) {
            return redirect()->route('auth.login')->withErrors(['error' => 'Você precisa estar logado.']);
        }

        // if (session('locked')) {
        //     return redirect()->route('auth.lock.screen');
        // }

        if (session('locked')) {
            return redirect()->route('auth.lock.screen')->withErrors(['error' => 'Sessão bloqueada. Informe sua senha.']);
        }

        return $next($request);
    }
}
