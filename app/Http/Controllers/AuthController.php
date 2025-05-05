<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            ]);

            return redirect('/admin/home');
        }

        return back()->withErrors(['login' => 'Usuário ou senha inválidos.']);
    }
}
