<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('Admin middleware check', [
            'path' => $request->path(),
            'authenticated' => auth()->check(),
            'is_admin' => auth()->check() ? auth()->user()->is_admin : 'not logged in'
        ]);

        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}