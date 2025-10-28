<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 🔹 1. Cria a tabela sem a foreign key
        Schema::create('sc_module', function (Blueprint $table) {
            $table->id();

            // Identificação básica
            $table->string('slug', 100)->unique()->comment('Identificador técnico do módulo');
            $table->string('name', 150)->comment('Nome exibido do módulo');
            $table->boolean('active')->default(true)->comment('Define se o módulo está ativo');

            // Organização e exibição
            $table->string('icon', 100)->nullable()->comment('Ícone do módulo');
            $table->integer('order')->default(0)->comment('Ordem de exibição nos menus');
            $table->unsignedBigInteger('id_parent')->nullable()->comment('ID do módulo pai, caso seja submódulo');

            // Controle interno e estrutura técnica
            $table->boolean('internal')->default(false)->comment('Define se o módulo é interno do sistema');
            $table->string('route_base', 150)->nullable()->comment('Rota base associada ao módulo');
            $table->string('model_path', 255)->nullable()->comment('Caminho completo do Model associado');
            $table->string('request_path', 255)->nullable()->comment('Caminho completo do Request associado');
            $table->string('controller_path', 255)->nullable()->comment('Caminho completo da Controller associada');

            // Datas
            $table->timestamps();
        });

        // 🔹 2. Adiciona a constraint depois que a tabela já existe
        Schema::table('sc_module', function (Blueprint $table) {
            $table->foreign('id_parent')
                ->references('id')
                ->on('sc_module')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sc_module');
    }
};
