<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class BaseApiController extends Controller
{
    protected function respond(bool $success, string $message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    protected function currentUserId(): int|null
    {
        $u = Auth::user();
        return $u ? (int) $u->id : null;
    }

    protected function booleanOrNull(mixed $value): bool|null
    {
        if (is_bool($value)) return $value;
        if ($value === '1' || $value === 1) return true;
        if ($value === '0' || $value === 0) return false;
        return null;
    }
}

