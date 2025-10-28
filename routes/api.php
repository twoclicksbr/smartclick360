<?php

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\UniversalController;
use Illuminate\Support\Facades\Route;

// 🔧 Configuração global para JSON formatado e sem barras invertidas
$flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

// 🔹 /api → mensagem principal da API
Route::prefix('/')->group(function () use ($flags) {
    Route::get('/', function () use ($flags) {
        return response()->json([
            'url' => request()->fullUrl(),
            'message' => 'API SmartClick360 — defina um endpoint correto.',
            'copy' => '© TwoClicks',
        ], 200, [], $flags);
    });

    // 🔹 /api/v1 → mensagem da versão
    Route::prefix('v1')->group(function () use ($flags) {
        Route::get('/', function () use ($flags) {
            return response()->json([
                'url' => request()->fullUrl(),
                'message' => 'API SmartClick360 — v1 — defina um endpoint correto.',
                'copy' => '© TwoClicks',
            ], 200, [], $flags);
        });

        // 🔹 /api/v1/{module} → módulos reais
        Route::prefix('{module}')->group(function () use ($flags) {

            // Função auxiliar de verificação
            $validateModule = function ($module) use ($flags) {
                $exists = DB::table('sc_module')
                    ->where('slug', $module)
                    ->where('active', true)
                    ->exists();

                if (! $exists) {
                    return response()->json([
                        'url' => request()->fullUrl(),
                        'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                        'copy' => '© TwoClicks',
                    ], 404, [], $flags);
                }

                return null;
            };

            Route::get('/', function ($module) use ($validateModule, $flags) {
                if ($error = $validateModule($module)) return $error;
                return app(UniversalController::class)->index(request(), $module);
            });

            Route::post('/', function ($module) use ($validateModule, $flags) {
                if ($error = $validateModule($module)) return $error;
                return app(UniversalController::class)->store(request(), $module);
            });

            Route::put('{id}', function ($module, $id) use ($validateModule, $flags) {
                if ($error = $validateModule($module)) return $error;
                return app(UniversalController::class)->update(request(), $module, $id);
            });

            Route::delete('{id}', function ($module, $id) use ($validateModule, $flags) {
                if ($error = $validateModule($module)) return $error;
                return app(UniversalController::class)->destroy($module, $id);
            });

            Route::fallback(function () use ($flags) {
                return response()->json([
                    'url' => request()->fullUrl(),
                    'message' => 'Módulo não encontrado na API SmartClick360 v1.',
                    'copy' => '© TwoClicks',
                ], 404, [], $flags);
            });
        });
    });
});

// 🔹 Fallback global — rota não encontrada
Route::fallback(function () use ($flags) {
    return response()->json([
        'url' => request()->fullUrl(),
        'message' => 'Endpoint não encontrado na API SmartClick360.',
        'copy' => '© TwoClicks',
    ], 404, [], $flags);
});
