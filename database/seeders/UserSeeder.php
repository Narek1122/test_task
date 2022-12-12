<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'login' => 'john',
                'password' => '123456'
            ],
            [
                'login' => 'john2',
                'password' => '123456'
            ],
            [
                'login' => 'john3',
                'password' => '123456'
            ],
            [
                'login' => 'john4',
                'password' => '123456'
            ],
            [
                'login' => 'john5',
                'password' => '123456'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}