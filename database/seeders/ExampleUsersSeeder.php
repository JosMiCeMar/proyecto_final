<?php

namespace Database\Seeders;

use App\Models\Administradore;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Responsable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder class para poblar la tabla users, responsables, administradores y clientes.
 */
class ExampleUsersSeeder extends Seeder
{
    /**
     * Ejecutar el seeder.
     * @return void
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

        //RESPONSABLES
        User::create([
            'nombre' => 'Depilaser MC',
            'apellidos' => 'Resp',
            'telefono' => '666666666',
            'email' => 'responsable@responsable.com',
            'password' => Hash::make('responsable1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Responsable::create([
            'user_id' => User::where('nombre', 'Depilaser MC')->first()->id,
            'centro_id' => 1
        ]);

        User::create([
            'nombre' => 'Ana',
            'apellidos' => 'Resp',
            'telefono' => '666666666',
            'email' => 'responsable@ana.com',
            'password' => Hash::make('responsable1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Responsable::create([
            'user_id' => User::where('nombre', 'Ana')->first()->id,
            'centro_id' => 2
        ]);

        User::create([
            'nombre' => 'Lais',
            'apellidos' => 'Resp',
            'telefono' => '666666666',
            'email' => 'responsable3@responsable.com',
            'password' => Hash::make('responsable1234'),
            'email_verified_at'=>Carbon::today()
        ]);

        Responsable::create([
            'user_id' => User::where('nombre', 'Lais')->first()->id,
            'centro_id' => 3
        ]);


        //CLIENTES
        $clientes = [
            [
                'nombre' => 'Carlos',
                'apellidos' => 'Martínez',
                'telefono' => '666111111',
                'email' => 'carlos.martinez@cliente.com',
                'password' => 'cliente1234',
                'verificado' => true,
                'condicion_especial' => false,
                'fecha_nacimiento' => '1988-12-12',
            ],
            [
                'nombre' => 'Laura',
                'apellidos' => 'Fernández',
                'telefono' => '666222222',
                'email' => 'laura.fernandez@cliente.com',
                'password' => 'cliente1234',
                'verificado' => false,
                'condicion_especial' => true,
                'fecha_nacimiento' => '1990-05-22',
            ],
            [
                'nombre' => 'Javier',
                'apellidos' => 'Pérez',
                'telefono' => '666333333',
                'email' => 'javier.perez@cliente.com',
                'password' => 'cliente1234',
                'verificado' => true,
                'condicion_especial' => false,
                'fecha_nacimiento' => '1995-08-10',
            ],
            [
                'nombre' => 'Ana',
                'apellidos' => 'Gómez',
                'telefono' => '666444444',
                'email' => 'ana.gomez@cliente.com',
                'password' => 'cliente1234',
                'verificado' => false,
                'condicion_especial' => true,
                'fecha_nacimiento' => '1985-03-15',
            ],
            [
                'nombre' => 'David',
                'apellidos' => 'López',
                'telefono' => '666555555',
                'email' => 'david.lopez@cliente.com',
                'password' => 'cliente1234',
                'verificado' => true,
                'condicion_especial' => false,
                'fecha_nacimiento' => '2000-07-18',
            ]
        ];

        foreach ($clientes as $cliente) {
            $user = User::create([
                'nombre' => $cliente['nombre'],
                'apellidos' => $cliente['apellidos'],
                'telefono' => $cliente['telefono'],
                'email' => $cliente['email'],
                'password' => Hash::make($cliente['password']),
                'email_verified_at' => $cliente['verificado'] ? Carbon::now() : null,
            ]);

            Cliente::create([
                'user_id' => $user->id,
                'condicion_especial' => $cliente['condicion_especial'],
                'fecha_nacimiento' => $cliente['fecha_nacimiento'],
            ]);
        }
    }
}
