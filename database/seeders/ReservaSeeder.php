<?php

namespace Database\Seeders;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $horaInicio = Carbon::createFromTime(10, 0, 0); 
        $horaFin = Carbon::createFromTime(11, 0, 0);
        Reserva::create([
            'cliente_id' => 1,
            'zona_id' => 7,
            'dia_id' => 1,
            'hora_inicio' => $horaInicio->toTimeString(),
            'hora_fin' => $horaFin->toTimeString(),
        ]);

        Reserva::create([
            'cliente_id' => 2,
            'zona_id' => 7,
            'dia_id' => 2,
            'hora_inicio' => $horaInicio->toTimeString(),
            'hora_fin' => $horaFin->toTimeString(),
        ]);

        Reserva::create([
            'cliente_id' => 1,
            'zona_id' => 7,
            'dia_id' => 2,
            'hora_inicio' => $horaInicio->addHour()->toTimeString(),
            'hora_fin' => $horaFin->addHour()->toTimeString(),
        ]);

        Reserva::create([
            'cliente_id' => 1,
            'zona_id' => 8,
            'dia_id' => 4,
            'hora_inicio' => $horaInicio->addHour()->toTimeString(),
            'hora_fin' => $horaFin->addHour()->toTimeString(),
        ]);

        Reserva::create([
            'cliente_id' => 1,
            'zona_id' => 7,
            'dia_id' => 4,
            'hora_inicio' => $horaInicio->addHour()->toTimeString(),
            'hora_fin' => $horaFin->addHour()->toTimeString(),
        ]);
    }
}
