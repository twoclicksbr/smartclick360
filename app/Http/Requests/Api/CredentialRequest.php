<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CredentialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'        => 'required|string|max:255|unique:credential,username,' . $this->id,
            'is_master'       => 'boolean',
            'active'          => 'boolean',
            'deleted'         => 'boolean',
            'dt_expiration'   => 'nullable|date',
            'dt_limit_access' => 'nullable|date',
        ];
    }
}
