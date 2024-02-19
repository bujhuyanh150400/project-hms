<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Specialties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchedulesController extends Controller
{
    //

    public function __construct()
    {
    }

    public function find_schedules(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);
        $title = 'Đặt lịch khám bệnh';
        $specialties = Specialties::all();
        $specialtyId = Specialties::pluck('id')->toArray();
        $dataRender = [
            'customer' => $customer,
            'title' => $title,
            'specialties' => $specialties
        ];
        if ($request->isMethod('POST')) {
            $validatorDateSchedule = Validator::make([
                'date' => $request->date('date'),
                'specialty' => $request->integer('specialty')
            ], [
                'date' => 'required|date|after_or_equal:today',
                'specialty' => ['required', Rule::in($specialtyId)]
            ], [
                'date.required' => 'Hãy nhập ngày đặt khám',
                'date.date' => 'Phải là ngày tháng',
                'date.after_or_equal' => 'Ngày không được nhỏ hơn ngày hiện tại.',
                'specialty.required' => 'Hãy chọn chuyên ngành cần khám',
                'specialty.in' => 'Chuyên ngành không hợp lệ',
            ]);
            if ($validatorDateSchedule->fails()) {
                return redirect()->back()->withErrors($validatorDateSchedule)->withInput();
            }
            $bookings = Booking::FindDate($request->date('date'))
                ->SpecialtyUser($request->integer('specialty'))
                ->get();
            $dataRender['bookings'] = $bookings;
        }
        return view('Admin.Customer.find_schedules', $dataRender);
    }

    function view_add_schedules(Request $request, $customer_id)
    {
        $title = 'Đặt lịch khám bệnh';
        $timeType = $request->get('time_type');
        $customer = Customer::find($customer_id);
        $animals = Animal::where('customer_id', $customer_id)->get();
        $user = User::find($request->integer('user_id'));
        $booking = Booking::find($request->integer('booking_id'));
        return view('Admin.Customer.add_schedules', compact('title', 'customer', 'timeType', 'user', 'booking', 'animals'));
    }

    function add_schedules(Request $request, $customer_id)
    {
        $validator = Validator::make($request->all(), []);
    }
}
