<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ellenőrizze, hogy a felhasználó be van-e jelentkezve
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ellenőrizze, hogy a felhasználónak van-e valamelyik megadott rangja
        foreach ($roles as $role) {
            if (auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Ha a felhasználónak nincs megfelelő rangja, akkor hozzáférés megtagadása
        return redirect()->route('dashboard')->with('error', 'Nincs megfelelő jogosultságod a hozzáféréshez!');
    }
}