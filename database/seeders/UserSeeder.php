<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'first_name' => 'Árpád',
                'last_name' => 'Figura',
                'username' => 'Mexter',
                'email' => 'figuraarpad03@gmail.com',
                'password' => Hash::make('admin1234'),
            ],
        ];

        $users = [
            [
                'first_name' => 'Elek',
                'last_name' => 'Teszt',
                'username' => 'Tesztelek',
                'email' => 'teszt@elek.hu',
                'password' => Hash::make('test1234'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        foreach ($admins as $userData) {
            $user = User::create($userData);
            $user->assignRole('admin');
        }
    }
}