<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $userA = User::where('email', 'usera@mail.com')->first();
        $userB = User::where('email', 'userb@mail.com')->first();

        if (! $userA || ! $userB) {
            return;
        }

        Project::create([
            'uuid'        => Str::uuid(),
            'user_id'     => $userA->id,
            'title'       => 'User A Project',
            'description' => 'Project owned by User A',
        ]);

        Project::create([
            'uuid'        => Str::uuid(),
            'user_id'     => $userB->id,
            'title'       => 'User B Project',
            'description' => 'Project owned by User B',
        ]);
    }
}
