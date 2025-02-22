<?php

namespace Database\Seeders;

use App\Models\Dia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder class para poblar la tabla dias.
 */
class DiaSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
     */
    public function run(): void
    {
        $hoy = Carbon::today();
        $centros = range(1, 7); // Centros del 1 al 7

        foreach ($centros as $centro) {
            $fechasUsadas = [];

            for ($i = 0; $i < 4; $i++) {
                do {
                    // Generar una fecha aleatoria antes o después del día actual
                    $fecha = $hoy->copy()->addMonth(rand(-15, 15));
                } while (in_array($fecha->toDateString(), $fechasUsadas)); // Evitar fechas duplicadas
                
                $fechasUsadas[] = $fecha->toDateString();

                Dia::create([
                    'centro_id' => $centro,
                    'fecha' => $fecha,
                ]);
            }
        }
    }
}
