<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Dia;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Seeder class para poblar la tabla reservas.
 */
class ReservaSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
     */
    public function run(): void
    {
        $clientes = Cliente::pluck('id')->toArray(); // Obtiene IDs de clientes
        $dias = Dia::pluck('id')->toArray(); // Obtiene IDs de los días disponibles

        foreach ($dias as $dia) {
            if (count($clientes) < 2) {
                continue; // Asegurar que haya al menos 2 clientes para elegir
            }

            // Seleccionar dos clientes aleatorios diferentes
            $clientesSeleccionados = array_rand($clientes, 3);
            $clienteManana = $clientes[$clientesSeleccionados[0]];
            $clienteManana2 = $clientes[$clientesSeleccionados[1]];
            $clienteTarde = $clientes[$clientesSeleccionados[2]];

            // Reserva en la mañana (10:00 - 10:30)
            Reserva::create([
                'cliente_id' => $clienteManana,
                'zona_id' => rand(1, 18), // Zona aleatoria
                'dia_id' => $dia,
                'hora_inicio' => Carbon::createFromTime(10, 0, 0)->toTimeString(),
                'hora_fin' => Carbon::createFromTime(10, 30, 0)->toTimeString(),
            ]);

            // Reserva en la mañana (10:30 - 11:00)
            Reserva::create([
                'cliente_id' => $clienteManana2,
                'zona_id' => rand(1, 18), // Zona aleatoria
                'dia_id' => $dia,
                'hora_inicio' => Carbon::createFromTime(10, 30, 0)->toTimeString(),
                'hora_fin' => Carbon::createFromTime(11, 0, 0)->toTimeString(),
            ]);

            // Reserva en la tarde (17:00 - 17:45)
            Reserva::create([
                'cliente_id' => $clienteTarde,
                'zona_id' => rand(1, 18), // Zona aleatoria
                'dia_id' => $dia,
                'hora_inicio' => Carbon::createFromTime(17, 0, 0)->toTimeString(),
                'hora_fin' => Carbon::createFromTime(17, 45, 0)->toTimeString(),
            ]);
        }
    }
}
