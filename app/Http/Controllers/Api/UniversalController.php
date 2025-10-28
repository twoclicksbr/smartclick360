<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BaseRequest;
use App\Models\Api\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UniversalController extends Controller
{
    /**
     * 🔹 Model e Request padrão
     */
    private string $defaultModel = BaseModel::class;

    private string $defaultRequest = BaseRequest::class;

    /**
     * 🔹 Listar registros
     */
    public function index(Request $request, string $module)
    {
        // 🔹 Tenta resolver o model
        $modelClass = $this->resolveModel($module);

        // 🔹 Instancia o model
        $model = new $modelClass;

        // 🔹 Define a tabela dinamicamente com base no nome do módulo
        $model->setTable($module);

        // 🔹 Verifica se a tabela realmente existe no banco
        if (! Schema::hasTable($module)) {
            return response()->json([
                'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                'copy' => '© TwoClicks',
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        // 🔹 Busca os registros com paginação
        $items = $model->query()->paginate(20);

        // 🔹 Retorna a resposta JSON formatada
        return response()->json([
            'module' => $module,
            'count' => $items->total(),
            'data' => $items->items(),
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 🔹 Criar registro
     */
    public function store(Request $request, string $module)
    {
        if (! $model = $this->resolveModel($module)) {
            return response()->json([
                'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                'copy' => '© TwoClicks',
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $model = $this->resolveModel($module);
        $requestClass = $this->resolveRequest($module);

        $validated = app($requestClass)->validated();

        $record = $model::create($validated);

        return response()->json([
            'message' => "Registro criado com sucesso em {$module}.",
            'data' => $record,
        ], 201, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 🔹 Atualizar registro
     */
    public function update(Request $request, string $module, int $id)
    {
        if (! $model = $this->resolveModel($module)) {
            return response()->json([
                'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                'copy' => '© TwoClicks',
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $model = $this->resolveModel($module);
        $requestClass = $this->resolveRequest($module);

        $validated = app($requestClass)->validated();

        $record = $model::findOrFail($id);
        $record->update($validated);

        return response()->json([
            'message' => "Registro atualizado com sucesso em {$module}.",
            'data' => $record,
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 🔹 Deletar registro
     */
    public function destroy(string $module, int $id)
    {
        if (! $model = $this->resolveModel($module)) {
            return response()->json([
                'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                'copy' => '© TwoClicks',
            ], 404, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $model = $this->resolveModel($module);
        $record = $model::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => "Registro excluído com sucesso de {$module}.",
        ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * 🔍 Resolve o Model dinamicamente com fallback padrão.
     */
    private function resolveModel(string $module): string
    {
        // Caminho esperado da model (ex: App\Models\Api\Person)
        $class = '\\App\\Models\\Api\\'.Str::studly($module);

        // Se a model específica existir, usa ela
        if (class_exists($class)) {
            return $class;
        }

        // Caso contrário, usa a BaseModel genérica
        return BaseModel::class;
    }

    /**
     * 🔍 Resolve o Request dinamicamente com fallback padrão.
     */
    private function resolveRequest(string $module): string
    {
        $class = '\\App\\Http\\Requests\\Api\\'.Str::studly($module).'Request';

        return class_exists($class) ? $class : $this->defaultRequest;
    }
}
