<?php

namespace App\Http\Middleware;

use App\Helper\PermissionAdmin;
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
                if ($user->permission !== PermissionAdmin::ADMIN && $user->permission !== PermissionAdmin::MANAGER) {
                    session()->flash('error', 'Bạn không có quyền truy cập');
                    return redirect()->route('admin.dashboard');
                }
                break;
        }
        return $next($request);
    }
}
