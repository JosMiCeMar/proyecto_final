<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration class para crear la tabla centros
 */
return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * @return void
     */
    public function up(): void
    {
        Schema::create('centros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->integer('telefono');
            $table->string('localidad');
            $table->string('provincia');
            $table->string('web')->nullable()->default(null); //Dato opcional
            $table->string('email')->nullable()->default(null); //Dato opcional
            $table->longText('ubicacion')->nullable()->default(null); //Dato opcional
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Revertir la migración.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('centros');
    }
};
