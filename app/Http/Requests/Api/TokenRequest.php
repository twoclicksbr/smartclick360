<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_credential' => 'required|integer|exists:credential,id',
            'id_person'     => 'required|integer|exists:person,id',
            'token'         => 'required|string|max:64|unique:token,token',
            'expires_at'    => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
