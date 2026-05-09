<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;


class UserHaveChallenge
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->challenge) {
            return redirect('challenges/create');
        }

        return $next($request);
    }
}
