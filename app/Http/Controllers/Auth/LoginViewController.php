<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginViewController extends Controller
{
    public function show()
    {
        return view('metronic.auth.login');
    }
}
