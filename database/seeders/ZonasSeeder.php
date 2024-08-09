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
            ['nombre'=>'Labio Superior','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Mentón','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Patillas','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Pomulo','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Cuello','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Linea Alba','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Manos','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Pies','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Nuca','precio'=>15,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Brazos Completos','precio'=>50,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Antebrazos','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Espalda Completa','precio'=>50,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'Media Espalda','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Ingles','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Perianal','precio'=>20,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Hombros','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Axilas','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Tórax','precio'=>50,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'Medio tórax','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'Piernas Completas','precio'=>60,'tiempo_estimado'=>'01:30'],
            ['nombre'=>'Medias Piernas','precio'=>40,'tiempo_estimado'=>'01:00']
        ];

        foreach($datos as $zona){
            Zona::create($zona);
        }
    }
}
