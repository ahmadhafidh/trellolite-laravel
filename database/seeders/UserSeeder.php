<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'usera@mail.com'],
            [
                'uuid'     => Str::uuid(),
                'name'     => 'User A',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'userb@mail.com'],
            [
                'uuid'     => Str::uuid(),
                'name'     => 'User B',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
