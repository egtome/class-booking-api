<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $usersData = [
            [
                'id' => 1,
                'email' => 'gino@test.com',
                'password' => Hash::make(env('USER_PASSWORD_FOR_TESTS')),
                'created_at' => now(),
            ],                 
        ];

        User::insert($usersData);
    }
}
