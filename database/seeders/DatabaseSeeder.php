<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Подключение seeder-классов
        $this->call([
            CourseSeeder::class,
            SpecializationSeeder::class,
            GroupSeeder::class,
            StudentSeeder::class,
            UserSeeder::class,
        ]);
    }
}
