<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckBlocked
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && Gate::allows('blocked', auth()->user())) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is blocked.',
                    'error' => 'Forbidden',
                    'code' => 403
                ], 403);
            } else {
                abort(403, 'Your account is blocked.');
            }
        }

        return $next($request);
    }
}
