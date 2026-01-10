<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Helpers\ApiResponse;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TaskController extends Controller
{
    public function __construct()
    {
        auth()->shouldUse('api');
    }

    public function index(string $projectUuid, Request $request)
    {
        $project = $this->getOwnedProject($projectUuid);

        $tasks = $project->tasks()
            ->when(
                $request->query('status'),
                fn ($q) => $q->where('status', $request->query('status'))
            )
            ->orderBy('due_date')
            ->get();

        return ApiResponse::success(
            TaskResource::collection($tasks),
            'Data ditemukan'
        );
    }

    public function store(Request $request, string $projectUuid)
    {
        $project = $this->getOwnedProject($projectUuid);

        $data = $this->validateTaskPayload($request);

        $task = $project->tasks()->create($data);

        return ApiResponse::success(
            new TaskResource($task),
            'Task berhasil dibuat',
            201
        );
    }

    public function show(string $projectUuid, string $taskUuid)
    {
        $project = $this->getOwnedProject($projectUuid);
        $task    = $this->getProjectTask($project, $taskUuid);

        return ApiResponse::success(
            new TaskResource($task),
            'Data ditemukan'
        );
    }

    public function update(
        Request $request,
        string $projectUuid,
        string $taskUuid
    ) {
        $project = $this->getOwnedProject($projectUuid);
        $task    = $this->getProjectTask($project, $taskUuid);

        $data = $this->validateTaskPayload($request);

        $task->update($data);

        return ApiResponse::success(
            new TaskResource($task),
            'Task berhasil diupdate'
        );
    }

    public function destroy(string $projectUuid, string $taskUuid)
    {
        $project = $this->getOwnedProject($projectUuid);
        $task    = $this->getProjectTask($project, $taskUuid);

        $task->delete();

        return ApiResponse::success(null, 'Task berhasil dihapus');
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

    private function getProjectTask(Project $project, string $taskUuid): Task
    {
        $task = $project->tasks()
            ->where('uuid', $taskUuid)
            ->first();

        if (! $task) {
            throw new NotFoundHttpException('Task not found');
        }

        return $task;
    }

    private function validateTaskPayload(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string',
            'status'      => 'required|in:pending,in_progress,done',
            'due_date'    => 'nullable|date_format:Y-m-d\TH:i:sP',
        ]);
    }
}
