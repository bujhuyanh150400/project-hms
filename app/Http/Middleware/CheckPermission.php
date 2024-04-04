<?php

namespace App\Http\Middleware;

use App\Helper\PermissionAdmin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    private bool $access = true;

    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        $user = Auth::guard('admin')->user();
        $route_name = $request->route()->getName();
        switch ($guard) {
            case 'adminOnly':
                if ($user->permission !== PermissionAdmin::ADMIN && $user->permission !== PermissionAdmin::MANAGER) {
                    $this->access = false;
                }
                if ($user->permission === PermissionAdmin::MANAGER && in_array($route_name, [
                        'clinic.list',
                        'clinic.view_add',
                        'clinic.add',
                        'clinic.view_edit',
                        'clinic.edit',
                    ])) {
                    $this->access = false;
                }
                break;
            case 'userEditSelf':
                if ($user->permission === PermissionAdmin::ADMIN ) {
                    $this->access = true;
                }else if ($request->route('id') != $user->id) {
                    $this->access = false;
                }
                break;
            case 'checkUserAccess':
                $doctor = [
                    'warehouse.view_add',
                    'warehouse.add',
                    'warehouse.view_edit',
                    'warehouse.edit',
                    'warehouse.log',
                    'warehouse.view_edit_total',
                    'warehouse.edit_total',
                    'bookings.find_list',
                    'bookings.all_bookings',
                    'schedules.find_list',
                ];
                $take_care = [
                    'warehouse.view_edit',
                    'warehouse.edit',
                    'warehouse.log',
                    'bookings.find_list',
                    'bookings.list',
                    'bookings.view_add',
                    'bookings.add',
                    'bookings.view_edit',
                    'bookings.edit',
                    'schedules.find_list',
                    'schedules.list',
                    'schedules.view',
                ];
                if ($user->permission === PermissionAdmin::DOCTOR && in_array($route_name, $doctor)) {
                    $this->access = false;
                }
                if ($user->permission === PermissionAdmin::TAKE_CARE && in_array($route_name, $take_care)) {
                    $this->access = false;
                }
                break;
        }
        if ($this->access === false) {
            session()->flash('error', 'Bạn không có quyền');
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}
