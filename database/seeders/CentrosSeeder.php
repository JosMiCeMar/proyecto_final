<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datos=[
            [
                'nombre'=>'Depilaser MC',
                'direccion'=>'Calle Cardenal Cisneros 22',
                'telefono'=>'666666666',
                'localidad'=>'Chillón',
                'provincia'=>'Ciudad Real',
                'web'=>null,
                'email'=>'depilasermc@gmail.com'
            ],
            [
                'nombre'=>'El paso de moron',
                'direccion'=>'Calle Sin nombre 11',
                'telefono'=>'666666666',
                'localidad'=>'Morón de la Frontera',
                'provincia'=>'Sevilla',
                'web'=>null,
                'email'=>null
            ]
            ];

            foreach($datos as $centro){
                Centro::create($centro);
            }
    }
}
