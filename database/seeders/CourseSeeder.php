<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => '1',
            ],
            [
                'name' => '2',
            ],
            [
                'name' => '3',
            ],
            [
                'name' => '4',
            ],
        ];
        foreach ($courses as $course) {
            Course::create($course);
        };
    }
}
