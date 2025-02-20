<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder class ejecuta los seeders de indicados
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar los seeders.
     * @return void
     */
    public function run(): void
    {
        $this->call([
            CentrosSeeder::class,
            ExampleUsersSeeder::class,
            ZonasSeeder::class,
            CodRegistroSeeder::class,
            DiaSeeder::class,
            ReservaSeeder::class,
            NotificacioneSeeder::class
        ]);
    }
}
