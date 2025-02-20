<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class para crear la tabla reservas
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * @return void
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('zona_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('dia_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
