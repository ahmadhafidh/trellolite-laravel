<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProjectController extends Controller
{
    public function __construct()
    {
        auth()->shouldUse('api');
    }

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

        $project = Project::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id'     => auth('api')->id(),
        ]);

        return ApiResponse::success($project, 'Project berhasil dibuat', 201);
    }

    public function show(string $uuid)
    {
        $project = $this->getOwnedProject($uuid);

        return ApiResponse::success($project, 'Data ditemukan');
    }

    public function update(Request $request, string $uuid)
    {
        $project = $this->getOwnedProject($uuid);

        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
        ]);

        $project->update($data);

        return ApiResponse::success($project, 'Project berhasil diupdate');
    }

    public function destroy(string $uuid)
    {
        $project = $this->getOwnedProject($uuid);

        $project->delete();

        return ApiResponse::success(null, 'Project berhasil dihapus');
    }

    private function getOwnedProject(string $uuid): Project
    {
        $project = Project::where('uuid', $uuid)->first();

        if (! $project) {
            throw new NotFoundHttpException('Project not found');
        }

        if ($project->user_id !== auth('api')->id()) {
            throw new AccessDeniedHttpException('User not allowed');
        }

        return $project;
    }
}
