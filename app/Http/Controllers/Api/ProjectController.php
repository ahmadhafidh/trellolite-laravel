<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        auth()->shouldUse('api');
    }

    /**
     * GET /api/projects
     */
    public function index()
    {
        $projects = Project::where('user_id', auth('api')->id())
            ->latest()
            ->get();

        return ApiResponse::success($projects, 'Data ditemukan');
    }

    /**
     * POST /api/projects
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id'     => auth('api')->id(),
        ]);

        return ApiResponse::success($project, 'Project berhasil dibuat', 201);
    }

    /**
     * GET /api/projects/{uuid}
     */
    public function show(string $uuid)
    {
        $project = $this->findOwnedProject($uuid);

        if (! $project) {
            return ApiResponse::error('User not allowed', 403);
        }

        return ApiResponse::success($project, 'Data ditemukan');
    }

    /**
     * PUT /api/projects/{uuid}
     */
    public function update(Request $request, string $uuid)
    {
        $project = $this->findOwnedProject($uuid);

        if (! $project) {
            return ApiResponse::error('User not allowed', 403);
        }

        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project->update($data);

        return ApiResponse::success($project, 'Project berhasil diupdate');
    }

    /**
     * DELETE /api/projects/{uuid}
     */
    public function destroy(string $uuid)
    {
        $project = $this->findOwnedProject($uuid);

        if (! $project) {
            return ApiResponse::error('User not allowed', 403);
        }

        $project->delete();

        return ApiResponse::success(null, 'Project berhasil dihapus');
    }

    /**
     * ==========================
     * Helper: ownership checker
     * ==========================
     */
    private function findOwnedProject(string $uuid): ?Project
    {
        return Project::where('uuid', $uuid)
            ->where('user_id', auth('api')->id())
            ->first();
    }
}
