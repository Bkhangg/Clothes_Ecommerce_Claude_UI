<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('app.employee_management')) {
            abort(404);
        }

        return $next($request);
    }
}
