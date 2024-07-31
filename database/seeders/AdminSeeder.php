<?php

namespace Database\Seeders;

use App\Models\Administradore;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre'=>'Admin',
            'apellidos'=>'Ejemplo',
            'telefono'=>'627876703',
            'email'=>'admin@admin.com',
            'password'=>Hash::make('admin1234')
        ]);

        Administradore::create([
            'user_id'=>User::where('nombre','Admin')->first()->id,
            
        ]);
    }
}
