<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{
    public function handle(Request $request, Closure $next, $guard = 'admin'): Response
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard('admin')->user();
            View::share('userLogin', $user);
            if ($request->route()->getName() === 'admin.login') {
                return redirect()->route('admin.dashboard');
            }
        } else {
            if ($request->route()->getName() !== 'admin.login' && $request->method() !== 'POST') {
                return redirect()->route('admin.login');
            }
        }
        return $next($request);
    }
}
