<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Log::info("Iniciando o seeding do banco de dados.");

        Log::info("Criando usuários de teste.");
        User::factory(10)->create();

        Log::info("Criando pagamentos de teste.");
        Payment::factory(20)->create();

        Log::info("Seeding do banco de dados concluído.");
    }
}
