<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPublic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            auth()->user()->role->libelle == 'root' ||
            auth()->user()->role->libelle == 'admin' ||
            auth()->user()->role->libelle == 'managershop' ||
            auth()->user()->role->libelle == 'managerhobby' ||
            auth()->user()->role->libelle == 'managerclub' ||
            auth()->user()->role->libelle == 'managerdancer' ||
            auth()->user()->role->libelle == 'managerdj' ||
            auth()->user()->role->libelle == 'auth' ||
            auth()->user()->role->libelle == 'public'
        ) {
            return $next($request);
        } else {
            abort(403);
        }
    }
}
