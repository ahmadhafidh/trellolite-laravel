<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth('api')->id())
            ->latest()
            ->get();

        return ApiResponse::success($projects, 'Data ditemukan');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project = Project::create($data);

        return ApiResponse::success($project, 'Project berhasil dibuat', 201);
    }

    public function show(Project $project)
    {
        return ApiResponse::success($project, 'Data ditemukan');
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project->update($data);

        return ApiResponse::success($project, 'Project berhasil diupdate');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return ApiResponse::success(null, 'Project berhasil dihapus');
    }
}
