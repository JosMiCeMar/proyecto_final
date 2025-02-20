<?php

namespace Database\Seeders;

use App\Models\CodRegistro;
use Illuminate\Database\Seeder;

/**
 * Seeder class para poblar la tabla cod_registros.
 */
class CodRegistroSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
     */
    public function run(): void
    {
        CodRegistro::create([
            'codigo' => 'ABCD1234',
            'id_creador' => 1,
            'usado' => false,
            'para_cliente' => true,
        ]);

        CodRegistro::create([
            'codigo' => 'DEFG4567',
            'id_creador' => 1,
            'usado' => true,
            'para_cliente' => false,
        ]);

        CodRegistro::create([
            'codigo' => 'GHIJ7890',
            'id_creador' => 2,
            'usado' => false,
            'para_cliente' => true,
        ]);
    }
}
