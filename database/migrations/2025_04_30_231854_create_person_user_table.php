<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('person_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_credential')->constrained('credential');
            $table->foreignId('id_person')->constrained('person');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(1);
            $table->boolean('deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_user');
    }
};
