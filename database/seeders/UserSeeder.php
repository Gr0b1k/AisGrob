<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [   
                'student_id' => null,
                'name' => 'Админ',
                'email' => 'admin@mail.ru',
                'login' => 'admin',
                'is_admin' => true,
                'password' => Hash::make('admin'),
            ],
            [   
                'student_id' => 1,
                'name' => 'Максим',
                'email' => 'user1@mail.ru',
                'login' => '456231',
                'is_admin' => false,
                'password' => Hash::make('123321'),
            ],
            [   
                'student_id' => 2,
                'name' => 'Олег',
                'email' => 'user2@mail.ru',
                'login' => '567876',
                'is_admin' => false,
                'password' => Hash::make('321123'),
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        };
    }
}
