<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Crear Roles Base
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $postulanteRole = Role::firstOrCreate(['name' => 'postulante']);

        /*
        |--------------------------------------------------------------------------
        | Crear Usuario Administrador
        |--------------------------------------------------------------------------
        */

        $admin = User::firstOrCreate(
            ['email' => 'admin@fundacion.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin1234'),
            ]
        );

        $admin->assignRole($adminRole);

        /*
        |--------------------------------------------------------------------------
        | Usuario de prueba postulante (opcional)
        |--------------------------------------------------------------------------
        */

        $postulante = User::firstOrCreate(
            ['email' => 'postulante@fundacion.com'],
            [
                'name' => 'Usuario Postulante',
                'password' => Hash::make('Postulante1234'),
            ]
        );

        $postulante->assignRole($postulanteRole);
    }
}
