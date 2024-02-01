<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            // Ha a felhasználó nincs bejelentkezve, átirányítjuk a bejelentkezési oldalra
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Ellenőrizzük, hogy a felhasználó rendelkezik-e bármelyik megadott szereppel
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
        // Ha a felhasználó nem rendelkezik bármelyik megadott szereppel, átirányítjuk egy hibaoldalra vagy vissza az előző oldalra
        return redirect()->route('dashboard')->with('error', 'Nincs megfelelő jogosultságod ehhez az oldalhoz.');
    }
}