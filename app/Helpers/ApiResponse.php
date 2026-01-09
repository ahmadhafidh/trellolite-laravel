<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', int $status = 200): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error(string $message = 'Error', int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}
