<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //Middleware can take extra arguments.
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()->hasRole($role)) {
            return redirect('/');
        }
        return $next($request);
    }

    // middleware to work after the response has been sent (like logging).
    public function terminate(Request $request, Response $response)
    {(
        Log::info('Request Completed'));
    }
}
