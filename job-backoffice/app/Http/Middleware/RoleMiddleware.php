<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (auth()->check())
        {
            $role = auth()->user()->role;
            $hasAcess = in_array($role,$roles);

            if(!$hasAcess)
            {
                abort(403);
            }

        }

        //Has acess
        return $next($request);
    }
}
