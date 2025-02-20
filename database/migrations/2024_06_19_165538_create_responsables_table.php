<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class para crear la tabla responsables
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * @return void
     */
    public function up(): void
    {
        Schema::create('responsables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('centro_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Revertir la migración.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('responsables');
    }
};
