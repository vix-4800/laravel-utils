<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {
        if (auth()->check() && Gate::allows('admin', auth()->user())) {
            return $next($request);
        }

        return redirect('/');
    }
}
