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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            //Si el usuario creador se elimina, la notificacion tambien
            $table->foreignId('user_id_orig')->constrained()->onDelete('cascade')->onUpdate('cascade');
            //Si el usuario destinatario se elimina, la notificacion tambien
            $table->foreignId('user_id_dest')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->mediumText('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
