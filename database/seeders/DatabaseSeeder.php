<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'dni' => '12345678',
            'password' => Hash::make('12345678'), 
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Ruby Mego',
            'email' => 'rubymego@gmail.com',
            'dni' => '87654321',
            'password' => Hash::make('87654321'),
            'role' => 'client',
        ]);

        $this->command->info('✅ Usuarios administrador y cliente creados correctamente.');
    }
}
