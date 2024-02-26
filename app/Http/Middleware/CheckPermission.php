<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{

    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        $user = Auth::guard('admin')->user();
        switch ($guard) {
            case 'adminOnly':
        }
        return $next($request);
    }
}
