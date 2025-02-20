<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class para crear la tabla dias
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * @return void
     */
    public function up(): void
    {
        Schema::create('dias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centro_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('dias');
    }
};
