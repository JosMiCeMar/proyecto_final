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
            ['nombre'=>'facial','precio'=>20,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'linea alba','precio'=>20,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'manos','precio'=>20,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'pies','precio'=>20,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'brazos completos','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'antebrazos','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'espalda completa','precio'=>60,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'media espalda','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'ingles','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'perianal','precio'=>20,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'hombros','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'axilas','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'tórax','precio'=>50,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'medio tórax','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'piernas completas','precio'=>60,'tiempo_estimado'=>'01:30'],
            ['nombre'=>'medias piernas','precio'=>40,'tiempo_estimado'=>'01:00']
        ];

        foreach($datos as $zona){
            Zona::create($zona);
        }
    }
}
