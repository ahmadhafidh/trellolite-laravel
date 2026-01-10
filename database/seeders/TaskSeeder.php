<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            Task::create([
                'uuid'        => Str::uuid(),
                'project_id'  => $project->id,
                'title'       => 'Setup database',
                'description' => 'Create initial database schema',
                'status'      => 'pending',
                'due_date'    => Carbon::now()->addDays(7),
            ]);

            Task::create([
                'uuid'        => Str::uuid(),
                'project_id'  => $project->id,
                'title'       => 'Implement API',
                'description' => 'Develop REST API endpoints',
                'status'      => 'in_progress',
                'due_date'    => Carbon::now()->addDays(14),
            ]);
        }
    }
}
