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

        foreach ([
            ['Administrador UES', 'admin@ues.edu.sv'],
            ['Arturo', 'arturo@ues.edu.sv'],
            ['Osiris', 'osiris@ues.edu.sv'],
        ] as [$name, $email]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => '123456', 'is_admin' => true],
            );
        }

        $activities = [
            ['Ponencias', 'ponencias', 'Tema, persona expositora, ideas centrales y aprendizajes.'],
            ['Talleres', 'talleres', 'Herramientas, procedimiento, práctica y resultados.'],
            ['Bingo', 'bingo', 'Dinámica, experiencia y participación.'],
            ['Feria de proyectos', 'feria-de-proyectos', 'Proyectos visitados, tecnologías e innovación.'],
            ['Comelona de pizza', 'comelona-de-pizza', 'Desarrollo, convivencia y experiencia.'],
            ['Torneo de fútbol sala', 'torneo-de-futbol-sala', 'Desarrollo, equipos y participación como jugador o espectador.'],
            ['Parrillada', 'parrillada', 'Descripción, convivencia y reflexión.'],
        ];

        foreach ($activities as [$name, $slug, $description]) {
            \App\Models\Category::firstOrCreate(['slug' => $slug], ['name' => $name, 'description' => $description]);
        }
    }
}
