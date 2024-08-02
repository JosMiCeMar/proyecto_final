<?php

namespace Database\Seeders;

use App\Models\Zona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $datos=[
            ['nombre'=>'Labio Superior','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Mentón','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Patillas','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Pomulo','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Cuello','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Linea Alba','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Manos','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Pies','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Nuca','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Brazos Completos','precio'=>50,'tiempo_estimado'=>'00:35'],
            ['nombre'=>'Antebrazos','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Espalda Completa','precio'=>50,'tiempo_estimado'=>'00:40'],
            ['nombre'=>'Media Espalda','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'Ingles','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'Perianal','precio'=>20,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'Hombros','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'Axilas','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'Tórax','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'Medio tórax','precio'=>30,'tiempo_estimado'=>'00:35'],
            ['nombre'=>'Piernas Completas','precio'=>60,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'Medias Piernas','precio'=>40,'tiempo_estimado'=>'00:45']
        ];

        foreach($datos as $zona){
            Zona::create($zona);
        }
    }
}
