<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $guarded = ['id'];

    /**
     * Define a tabela dinamicamente no momento da instância.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Se a tabela ainda não estiver definida, tenta usar o nome da rota/módulo
        if (empty($this->table) && request()->route('module')) {
            $this->setTable(request()->route('module'));
        }

        // Carrega automaticamente os campos existentes no banco
        $this->loadFillableFromDatabase();
    }

    /**
     * Carrega os campos da tabela no fillable de forma automática.
     */
    protected function loadFillableFromDatabase(): void
    {
        try {
            if (Schema::hasTable($this->getTable())) {
                $columns = Schema::getColumnListing($this->getTable());

                // Remove campos de controle que não devem ser preenchidos
                $this->fillable = array_values(array_diff($columns, [
                    'id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]));
            }
        } catch (\Throwable $e) {
            // Silencia erros se a tabela não existir ainda
        }
    }
}
