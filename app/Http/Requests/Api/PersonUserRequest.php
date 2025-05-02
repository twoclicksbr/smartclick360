<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonUserRequest extends FormRequest
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
            'email'         => [
                'required',
                'email',
                'max:255',
                Rule::unique('person_user')->where(function ($query) {
                    return $query->where('id_credential', $this->input('id_credential'));
                })->ignore($this->id),
            ],
            'password'      => 'required|string|min:6',
            'active'        => 'nullable|boolean',
        ];
    }
}
