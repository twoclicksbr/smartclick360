<?php

namespace App\Http\Controllers\Sys;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class CredentialController extends Controller
{
    public function index()
    {
        $http = Http::withHeaders([
            'token' => session('auth_token')
        ]);

        if (app()->isLocal()) {
            $http = $http->withoutVerifying();
        }

        $response = $http->get(env('APP_URL_API') . '/admin/credential');

        // Agora sim: extrai os dados da API
        $credentials = $response->json()['credential']['data'] ?? [];

        return view('metronic.system.credential', compact('credentials'));
    }
}
