<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Eluan Bocca',
            'email' => 'eluan.bocca@prof.sc.senac.br',
            'password' => bcrypt('12345678'),
            'role' => 'atendente',
        ]);

        User::factory()->create([
            'name' => 'Usuario Padrao',
            'email' => 'usuario@aulabackendsenac.com',
            'password' => bcrypt('12345678'),
            'role' => 'usuario',
        ]);
    }
}
