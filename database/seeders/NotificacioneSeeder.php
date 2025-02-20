<?php

namespace Database\Seeders;

use App\Models\Notificacione;
use Illuminate\Database\Seeder;

/**
 * Seeder class para poblar la tabla notificaciones.
 */
class NotificacioneSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
     */
    public function run(): void
    {
        // Notificación de Usuario 1 a Usuario 2
        Notificacione::create([
            'user_id_orig' => 1,
            'user_id_dest' => 2,
            'mensaje' => 'Notificación de ejemplo desde el seeder.',
        ]);

        // Notificación de Usuario 2 a Usuario 3
        Notificacione::create([
            'user_id_orig' => 2,
            'user_id_dest' => 3,
            'mensaje' => 'Notificación de ejemplo desde el seeder.',
        ]);

        // Notificación de Usuario 3 a Usuario 1
        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación de ejemplo desde el seeder.',
        ]);
    }
}
