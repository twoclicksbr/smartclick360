<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_credential' => 'required|integer|exists:credential,id',
            'name'          => 'required|string|max:255',
            'birthdate'     => 'nullable|date',
            'active'        => 'nullable|boolean',
        ];
    }
}
