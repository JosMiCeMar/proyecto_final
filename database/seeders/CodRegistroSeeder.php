<?php

namespace Database\Seeders;

use App\Models\CodRegistro;
use Illuminate\Database\Seeder;

class CodRegistroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CodRegistro::create([
            'codigo' => 'ABC123',
            'id_creador' => 1,
            'usado' => false,
            'para_cliente' => true,
        ]);

        CodRegistro::create([
            'codigo' => 'DEF456',
            'id_creador' => 1,
            'usado' => true,
            'para_cliente' => false,
        ]);

        CodRegistro::create([
            'codigo' => 'GHI789',
            'id_creador' => 2,
            'usado' => false,
            'para_cliente' => true,
        ]);
    }
}
