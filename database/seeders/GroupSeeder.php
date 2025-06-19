<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'course_id' => 1,
                'specialization_id' => 1,
                'name' => 'СП-1-21',
            ],
            [
                'course_id' => 2,
                'specialization_id' => 1,
                'name' => 'СП-1-21',
            ],
            [
                'course_id' => 3,
                'specialization_id' => 1,
                'name' => 'СП-1-21',
            ],
            [
                'course_id' => 4,
                'specialization_id' => 1,
                'name' => 'СП-1-21',
            ],
        ];
        foreach ($groups as $group) {
            Group::create($group);
        };
    }
}
