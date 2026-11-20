<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@greenweek.local')],
            ['name' => 'Administrador SDS26', 'password' => env('ADMIN_PASSWORD', 'cambia-esta-clave'), 'is_admin' => true],
        );

        foreach ([['IoT y tecnología', 'iot-tecnologia'], ['Sostenibilidad', 'sostenibilidad'], ['Vida universitaria', 'vida-universitaria']] as [$name, $slug]) {
            \App\Models\Category::firstOrCreate(['slug' => $slug], ['name' => $name, 'description' => 'Noticias y actividades de '.$name.'.']);
        }
    }
}
