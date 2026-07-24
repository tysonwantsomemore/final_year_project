<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Bạn chưa đăng nhập.',
            ], 401);
        }

        if (Schema::hasTable('roles') && Schema::hasColumn('users', 'role_id')) {
            $user->loadMissing('roleModel:id,name');
        }

        if (!$user->isAdmin()) {
            return response()->json([
                'message' => 'Bạn không có quyền truy cập chức năng quản trị.',
            ], 403);
        }

        return $next($request);
    }
}
