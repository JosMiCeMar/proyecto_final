<?php

namespace Database\Seeders;

use App\Models\Dia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hoy = Carbon::now();
        
        Dia::create([
            'centro_id' => 1,
            'fecha' => $hoy->copy()->addDays(12), 
        ]);

        Dia::create([
            'centro_id' => 1,
            'fecha' => $hoy->copy()->addDays(20), 
        ]);

        Dia::create([
            'centro_id' => 2,
            'fecha' => $hoy->copy()->addDays(22), 
        ]);
    }
}
