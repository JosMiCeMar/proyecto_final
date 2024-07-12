<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Responsable;
use Illuminate\Support\Facades\Hash;

class ExampleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'nombre'=>'Cliente',
            'apellidos'=>'Ejemplo',
            'telefono'=>'627876703',
            'email'=>'cliente@cliente.com',
            'password'=>Hash::make('cliente1234')
        ]);

        Cliente::create([
            'user_id'=>User::where('nombre','Cliente')->first()->id,
            'consentimiento'=>true,
            'condicion_especial'=>false,
            'fecha_nacimiento'=>'1988-12-12'
        ]);

        User::create([
            'nombre'=>'Responsable',
            'apellidos'=>'Ejemplo',
            'telefono'=>'627876703',
            'email'=>'responsable@responsable.com',
            'password'=>Hash::make('responsable1234')
        ]);

        Responsable::create([
            'user_id'=>User::where('nombre','Responsable')->first()->id,
            'centro_id'=>1
        ]);
    }
}
