<?php

namespace Database\Seeders;

use App\Models\Notificacione;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificacioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Notificación de Usuario 1 a Usuario 2
        Notificacione::create([
            'user_id_orig' => 1,
            'user_id_dest' => 2,
            'mensaje' => 'Hola Usuario 2, soy el Usuario 1.',
        ]);

        // Notificación de Usuario 2 a Usuario 3
        Notificacione::create([
            'user_id_orig' => 2,
            'user_id_dest' => 3,
            'mensaje' => 'Hola Usuario 3, soy el Usuario 2.',
        ]);

        // Notificación de Usuario 3 a Usuario 1
        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Hola Usuario 1, soy el Usuario 3.',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificacion 2',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 3',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 4',
        ]);
        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificacion 2',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 3',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 4',
        ]);
        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificacion 2',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 3',
        ]);

        Notificacione::create([
            'user_id_orig' => 3,
            'user_id_dest' => 1,
            'mensaje' => 'Notificación 4',
        ]);
    }
}
