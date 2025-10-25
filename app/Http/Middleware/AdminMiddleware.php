<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
       if (!Auth::check()) {
            return redirect()->route('login');
        }
         // Método alternativo si isAdmin() no funciona
        $user = Auth::user();
        if ($user->role !== 'admin') {
            return redirect()->route('client.dashboard');
        }
        return $next($request);
    }
}
