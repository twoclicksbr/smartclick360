<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Api\Credential;

class CredentialController extends Controller
{
    public function index()
    {
        $credentials = Credential::orderBy('id', 'desc')->get();
        return view('admin.credential.index', compact('credentials'));
    }
}
