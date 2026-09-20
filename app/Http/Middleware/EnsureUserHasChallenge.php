<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasChallenge
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->challenge) {
            return redirect()->route('challenges.create');
        }

        return $next($request);
    }
}
