<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name' => 'Программирование в компьютерных системах',
                'code' => '09.02.03',
                'cafedra' => 'Финансы',
            ],
        ];
        foreach ($specializations as $specialization) {
            Specialization::create($specialization);
        };
    }
}
