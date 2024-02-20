<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkSchedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->has('time_type') && $request->has('user_id') && $request->has('booking_id')) {
            $user = User::find($request->integer('user_id'));
            if (!$user) {
                session()->flash('error', 'Nhân viên không có trong hệ thống');
                return redirect()->route('customer.list');
            }
            $booking = Booking::find($request->integer('booking_id'));
            if (!$booking) {
                session()->flash('error', 'Không có thông tin lịch khám này');
                return redirect()->route('customer.list');
            }
            $listTimeTypeSelected = explode(',', $booking->timeTypeSelected);
            if (in_array($request->input('time_type'), $listTimeTypeSelected)) {
                session()->flash('error', 'Lịch khám này đã có khách hàng khác đặt');
                return redirect()->route('customer.list');
            }
        } else {
            session()->flash('error', 'Thiếu thông tin để đặt lịch khám bệnh');
            return redirect()->route('customer.list');
        }
        return $next($request);
    }
}
