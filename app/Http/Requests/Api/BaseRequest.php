<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class BaseRequest extends FormRequest
{
    /**
     * Autoriza todas as requisições por padrão.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define regras dinamicamente com base no módulo.
     */
    public function rules(): array
    {
        $module = $this->route('module');
        if (! $module) {
            return [];
        }

        // 🔹 Exemplo: busca as regras do módulo no banco de dados
        // (ajuste depois para a tabela que armazenará os campos)
        $fields = DB::table('sc_module_field')
            ->where('module_slug', $module)
            ->where('active', true)
            ->get();

        $rules = [];

        foreach ($fields as $field) {
            $ruleList = [];

            if ($field->required ?? false) {
                $ruleList[] = 'required';
            }

            if ($field->type === 'string') {
                $ruleList[] = 'string';
            } elseif ($field->type === 'integer') {
                $ruleList[] = 'integer';
            } elseif ($field->type === 'email') {
                $ruleList[] = 'email';
            }

            if (! empty($field->max_length)) {
                $ruleList[] = 'max:'.$field->max_length;
            }

            $rules[$field->name] = implode('|', $ruleList);
        }

        return $rules;
    }

    /**
     * Mensagens de erro padrão.
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'Informe um e-mail válido.',
            'integer' => 'O campo :attribute deve ser numérico.',
            'max' => 'O campo :attribute ultrapassa o tamanho máximo permitido.',
        ];
    }

    /**
     * Ajustes antes da validação (ex: normalizar dados).
     */
    protected function prepareForValidation(): void
    {
        // Exemplo: trimar strings e converter campos vazios para null
        $this->replace(array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $this->all()));
    }
}
