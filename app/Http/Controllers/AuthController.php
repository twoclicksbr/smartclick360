<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $response = Http::withoutVerifying()->post(env('APP_URL_API') . '/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            session([
                'idCredential' => $response['idCredential'],
                'username'     => $response['username'],
                'token'        => $response['token'],
                'idPerson'     => $response['idPerson'],
                'name'         => $response['name'],
                'email'        => $response['email'],
            ]);

            return redirect('/admin/home');
        }

        // return redirect('/login')->withErrors(['email' => 'Usuário ou senha inválidos.']);

        return redirect()->route('auth.login')->withErrors([
            'error' => 'E-mail ou senha inválidos.',
        ]);
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $personUser = \App\Models\Api\PersonUser::where('email', $request->email)->first();

        if (!$personUser || !Hash::check($request->password, $personUser->password)) {
            // return redirect()->back()->withErrors(['password' => 'Senha incorreta']);

            return redirect()->back()->withErrors(['error' => 'Senha incorreta']);
        }

        // ✅ Limpa a sessão de bloqueio
        session()->forget('locked');

        return redirect('/admin/home');
    }
}
