<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle(Request $request, Closure $next)
    {
          if (!Auth::check()) {
            return redirect()->route('login');
        }
         $user = Auth::user();
        if ($user->role !== 'client') {
            return redirect()->route('admin.dashboard');
        }
        

        return $next($request);
    }
}
