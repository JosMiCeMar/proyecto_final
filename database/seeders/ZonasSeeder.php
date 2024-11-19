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
            ['nombre'=>'facial','precio'=>15,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'linea alba','precio'=>15,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'manos','precio'=>15,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'pies','precio'=>15,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'brazos completos','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'antebrazos','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'espalda completa','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'media espalda','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'ingles','precio'=>30,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'perianal','precio'=>30,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'hombros','precio'=>30,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'axilas','precio'=>30,'tiempo_estimado'=>'00:15'],
            ['nombre'=>'tórax','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'pecho','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'abdomen','precio'=>30,'tiempo_estimado'=>'00:30'],
            ['nombre'=>'piernas completas','precio'=>70,'tiempo_estimado'=>'01:00'],
            ['nombre'=>'medias piernas','precio'=>50,'tiempo_estimado'=>'00:45'],
            ['nombre'=>'gluteos','precio'=>30,'tiempo_estimado'=>'00:30'],
        ];

        foreach($datos as $zona){
            Zona::create($zona);
        }
    }
}
