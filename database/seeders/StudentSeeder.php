<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'group_id' => 4,
                'orders_id' => null,
                'fio' => 'Гробовик Максим Алексеевич',
                'phone' => '89954281086',
                'addres' => 'Г. Волгоград ул. Волгоградская 82',
                'studentNumber' => '456231',
                'is_active' => true,
                'dateStart' => '01.09.2021',
                'dateEnd' => '30.06.2025',
            ],
            [
                'group_id' => 2,
                'orders_id' => null,
                'fio' => 'Ефремов Олег Алексеевич',
                'phone' => '89956437652',
                'addres' => 'Г. Волгоград ул. Ефремова 23',
                'studentNumber' => '567876',
                'is_active' => true,
                'dateStart' => '01.09.2021',
                'dateEnd' => '30.06.2025',
            ],
        ];
        foreach ($students as $student) {
            Student::create($student);
        };
    }
}