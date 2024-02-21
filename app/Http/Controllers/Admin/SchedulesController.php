<?php

namespace App\Http\Controllers\Admin;

use App\Helper\SchedulesStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Schedules;
use App\Models\Specialties;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchedulesController extends Controller
{
    //
    const PER_PAGE = 10;
    public function __construct()
    {
    }

    public function find_list(Request $request)
    {
        $title = 'Tìm kiếm lịch khám bệnh';
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $users = User::KeywordFilter($filter->get('keyword'))
            ->RoleFilter($filter->get('role'))
            ->paginate($limit);
        return view('Admin.Schedules.find_list', compact('users', 'filter', 'users', 'title'));
    }
    public function list(Request $request, $user_id)
    {
        $title = 'Chi tiết lịch khám';
        $user = User::find($user_id);
        if ($user) {
            $filter = $request->input('filter', []);
            if (!isset($filter['start_date_create'])) {
                $filter['start_date_create'] = now()->startOfWeek();
            };
            if (!isset($filter['end_date_create'])) {
                $filter['end_date_create'] = now()->endOfWeek();
            };
            $schedules = Schedules::whereUser($user_id)
                ->whereCustomer($filter['customer'] ?? null)
                ->DateFilter([$filter['start_date_create'], $filter['end_date_create']])
                ->paginate(self::PER_PAGE);
            return view('Admin.Schedules.list', compact('schedules', 'user', 'filter', 'title'));
        } else {
            session()->flash('error', 'Không tìm thấy người dùng!');
            return redirect()->route('schedules.find_list');
        }
    }
    public function view($schedule_id)
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
        $validator = Validator::make($request->all(), [
            'animal' => [
                'required',
                'integer',
                Rule::exists('animals', 'id')->where(function ($query) use ($customer_id) {
                    $query->where('customer_id', $customer_id);
                })
            ],
            'description' => 'nullable|min:5',
        ], [
            'animal.required' => 'Vui lòng chọn một thú cưng.',
            'animal.exists' => 'thú cưng không hợp lệ hoặc không thuộc quyền sở hữu của khách hàng.',
            'description.min' => 'Ghi chú khám phải lớn hơn 5 kí tự.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'timeType' => $request->integer('time_type'),
            'booking_id' => $request->integer('booking_id'),
            'description' => $request->input('description'),
            'animal_id' => $request->integer('animal'),
            'customer_id' => intval($customer_id),
            'user_id' => $request->integer('user_id'),
            'status' =>  SchedulesStatus::ON_SCHEDULES,
        ];
        $schedule = Schedules::create($data);
        if ($schedule) {
            $booking = Booking::find($request->integer('booking_id'));
            $timeTypeSelected = empty($booking->timeTypeSelected) ? [] : explode(',', $booking->timeTypeSelected);
            $timeTypeSelected[] = $request->integer('time_type');
            $booking->timeTypeSelected = implode(',', $timeTypeSelected);
            $booking->save();
            session()->flash('success', 'Đặt lịch thành công!');
            return redirect()->route('customer.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi insert database');
            return redirect()->back()->withInput();
        }
    }
}
