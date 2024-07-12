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
                'email'=>'depilasermc@gmail.com',
                'ubicacion'=>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3109.544729018183!2d-4.873737815951818!3d38.79707009889373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6b45dc17f1c9f7%3A0x2470b8b1079ed62a!2sC.%20Cardenal%20Cisneros%2C%2022%2C%2013412%20Chill%C3%B3n%2C%20Ciudad%20Real!5e0!3m2!1ses!2ses!4v1720796559362!5m2!1ses!2ses'
            ],
            [
                'nombre'=>'Centro de Ana',
                'direccion'=>'Calle Sin nombre 11',
                'telefono'=>'666666666',
                'localidad'=>'Morón de la Frontera',
                'provincia'=>'Sevilla'
            ]
            ,
            [
                'nombre'=>'Lais Nails',
                'direccion'=>'Av. Ramón y Cajal, 15',
                'telefono'=>'666666666',
                'localidad'=>'Almadén',
                'provincia'=>'Ciudad Real',
                'ubicacion'=>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d326.9457284541406!2d-4.831904676030467!3d38.776328763414284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6b444264d1ba2d%3A0x27282210c64fda09!2sAv.%20Ram%C3%B3n%20y%20Cajal%2C%2015%2C%2013400%20Almad%C3%A9n%2C%20Ciudad%20Real!5e0!3m2!1ses!2ses!4v1720801721689!5m2!1ses!2se'
            ]
            ];

            foreach($datos as $centro){
                Centro::create($centro);
            }
    }
}
