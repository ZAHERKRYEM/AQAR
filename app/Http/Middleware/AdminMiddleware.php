<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->user_type !== 'admin') {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Unauthorized',
                'status_code' => 403
            ], 403);
        }
        return $next($request);
    }
}
