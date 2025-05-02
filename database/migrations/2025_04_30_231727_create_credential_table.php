<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('credential', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->boolean('is_master')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('deleted')->default(0);
            $table->date('dt_expiration')->nullable();
            $table->date('dt_limit_access')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credential');
    }
};
