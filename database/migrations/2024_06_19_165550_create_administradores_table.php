<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class para crear la tabla administradores
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * @return void
     */
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Revertir la migración.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
