<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PermissionAdmin;
use App\Helper\SchedulesStatus;
use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    const PER_PAGE = 30;
    public function index()
    {
        $user = Auth::guard('admin')->user();
        if ($user->permission === PermissionAdmin::ADMIN){
            $histories = History::whereHas('schedules',function ($query){
                $query->where('status',SchedulesStatus::HAS_PAYMENT);
            })->with(['schedules.user','schedules.user.clinic','schedules.user.specialties','animal','animal.customer'])->paginate(self::PER_PAGE);
        }elseif ($user->permission === PermissionAdmin::MANAGER || $user->permission === PermissionAdmin::TAKE_CARE){
            $histories = History::whereHas('schedules',function ($query){
                $query->where('status',SchedulesStatus::HAS_PAYMENT);
                $query->whereHas('user',function ($query_user){
                    $query_user->where('specialties_id',Auth::guard('admin')->user()->specialties_id);
                });
            })->with(['schedules.user','schedules.user.clinic','schedules.user.specialties','animal','animal.customer'])->paginate(self::PER_PAGE);
        }else{
            $histories = History::whereHas('schedules',function ($query){
                $query->where('status',SchedulesStatus::HAS_PAYMENT);
                $query->whereHas('user',function ($query_user){
                    $query_user->where('id',Auth::guard('admin')->user()->id);
                });
            })->with(['schedules.user','schedules.user.clinic','schedules.user.specialties','animal','animal.customer'])->paginate(self::PER_PAGE);
        }
        return view('Admin.Dashboard.index', [
            'title' => 'Dashboard - HMS',
            'histories'=>$histories
        ]);
    }
}
