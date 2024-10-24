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
        Schema::create('cod_registros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            //En caso de eliminar el usuario, quedaria null
            $table->foreignId('id_creador')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('usado')->default(false);
            $table->boolean('para_cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cod_registros');
    }
};
