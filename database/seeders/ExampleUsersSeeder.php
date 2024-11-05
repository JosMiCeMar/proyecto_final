<?php

namespace Database\Seeders;

use App\Models\Administradore;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ExampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ADMINISTRADOR
        User::create([
            'nombre' => 'Admin',
            'apellidos' => 'Ejemplo',
            'telefono' => '666666666',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Administradore::create([
            'user_id' => User::where('nombre', 'Admin')->first()->id,

        ]);

        //RESPONSABLE
        User::create([
            'nombre' => 'Responsable',
            'apellidos' => 'Ejemplo',
            'telefono' => '666666666',
            'email' => 'responsable@responsable.com',
            'password' => Hash::make('responsable1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Responsable::create([
            'user_id' => User::where('nombre', 'Responsable')->first()->id,
            'centro_id' => 1
        ]);


        //CLIENTES
        User::create([
            'nombre' => 'Cliente',
            'apellidos' => 'Ejemplo',
            'telefono' => '666666666',
            'email' => 'cliente@cliente.com',
            'password' => Hash::make('cliente1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Cliente::create([
            'user_id' => User::where('nombre', 'Cliente')->first()->id,
            'condicion_especial' => false,
            'fecha_nacimiento' => '1988-12-12'
        ]);

        User::create([
            'nombre' => 'Cliente_dos',
            'apellidos' => 'Ejemplo',
            'telefono' => '666666666',
            'email' => 'cliente2@cliente.com',
            'password' => Hash::make('cliente1234')
        ]);

        Cliente::create([
            'user_id' => User::where('nombre', 'Cliente_dos')->first()->id,
            'condicion_especial' => true,
            'fecha_nacimiento' => '1988-12-12'
        ]);
    }
}
