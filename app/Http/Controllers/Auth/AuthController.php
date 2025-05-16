<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
                'auth_idCredential' => $response['idCredential'],
                'auth_username'     => $response['username'],
                'auth_token'        => $response['token'],
                'auth_idPerson'     => $response['idPerson'],
                'auth_name'         => $response['name'],
                'auth_firstName'    => explode(' ', $response['name'])[0],
                'auth_email'        => $response['email'] ?? $request->email,
            ]);

            return redirect()->route('sys.home');
        }

        return redirect()->route('auth.login')->with([
            'error_title' => 'Erro no login',
            'error_message' => 'E-mail ou senha inválidos. Verifique os dados e tente novamente.',
        ]);
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $email = session('auth_email');

        if (!$email) {
            return redirect()->route('auth.login')->with([
                'error_title' => 'Sessão expirada',
                'error_message' => 'Faça login novamente para continuar.',
            ]);
        }

        $personUser = \App\Models\Api\PersonUser::where('email', $email)->first();

        if (!$personUser || !Hash::check($request->password, $personUser->password)) {
            return redirect()->back()->with([
                'error_title' => 'Falha na autenticação',
                'error_message' => 'Senha incorreta. Tente novamente.',
            ]);
        }

        session()->forget('locked');

        return redirect('/sys');
    }


    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.login');
    }
}
