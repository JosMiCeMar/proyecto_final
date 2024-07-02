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
            ['nombre'=>'labio superior','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'menton','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'patillas','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'pomulo','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'cuello','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'linea alba','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'manos','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'pies','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'nuca','precio'=>15,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'brazos completos','precio'=>50,'tiempo_estimado'=>'00:35'],
            ['nombre'=>'antebrazos','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'espalda completa','precio'=>50,'tiempo_estimado'=>'00:40'],
            ['nombre'=>'media espalda','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'ingles','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'perianal','precio'=>20,'tiempo_estimado'=>'00:20'],
            ['nombre'=>'hombros','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'axilas','precio'=>30,'tiempo_estimado'=>'00:25'],
            ['nombre'=>'torax','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'medio torax','precio'=>30,'tiempo_estimado'=>'00:35'],
            ['nombre'=>'piernas completas','precio'=>60,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'medias piernas','precio'=>40,'tiempo_estimado'=>'00:45']
        ];

        foreach($datos as $zona){
            Zona::create($zona);
        }
    }
}
