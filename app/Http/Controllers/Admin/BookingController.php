<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PermissionAdmin;
use App\Helper\TimeType;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    private const PER_PAGE = 10;
    public function __construct()
    {
    }

    public function find_list(Request $request)
    {
        $title = 'Tìm kiếm lịch khám bệnh';
        $filter = collect($request->input('filter', []));
        if ($this->getUserLogin()->permission === PermissionAdmin::MANAGER) {
            $filter->put('clinic_id', $this->getUserLogin()->clinic_id);
        }
        $limit = $request->input('limit', self::PER_PAGE);
        $users = User::KeywordFilter($filter->get('keyword'))
            ->ClinicFilter($filter->get('clinic_id'))
            ->RoleFilter($filter->get('role'))
            ->paginate($limit);
        return view('Admin.Bookings.find_list', compact('users', 'filter', 'users', 'title'));
    }

    public function list(Request $request, $user_id)
    {
        if ($this->getUserLogin()->permission === PermissionAdmin::DOCTOR) {
            $user = User::find($this->getUserLogin()->id);
        } else {
            $user = User::find($user_id);
        }
        if ($user) {
            $title = 'Lịch khám của ' . $user->name;
            $filter = $request->input('filter', []);
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();
            if (!isset($filter['start_date_create'])) {
                $filter['start_date_create'] = $startOfWeek;
            };
            if (!isset($filter['end_date_create'])) {
                $filter['end_date_create'] = $endOfWeek;
            };
            $bookings = Booking::where('user_id',  $user->id)
                ->DateFilter([$filter['start_date_create'], $filter['end_date_create']])
                ->paginate(self::PER_PAGE);
            return view('Admin.Bookings.list', compact('title', 'user', 'bookings', 'filter'));
        } else {
            session()->flash('error', 'Không có lịch làm này trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }
    public function all_bookings(Request $request){
        $title = 'Lịch làm các bác sĩ của cơ sở';
        $filter = $request->input('filter', []);
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        if (!isset($filter['start_date_create'])) {
            $filter['start_date_create'] = $startOfWeek;
        };
        if (!isset($filter['end_date_create'])) {
            $filter['end_date_create'] = $endOfWeek;
        };
        $clinic_id = $this->getUserLogin()->clinic_id;
        $users = User::ClinicFilter($clinic_id)->BookingDateFilterBetween($filter['start_date_create'], $filter['end_date_create'])->paginate(5);
        return view('Admin.Bookings.all_bookings', compact('title',  'users', 'filter'));
    }
    public function view_add(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $title = 'Đăng kí lịch khám';
            return view('Admin.Bookings.add', compact('title', 'user'));
        } else {
            session()->flash('error', 'Nhân viên không có trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }
    public function add(Request $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $timeTypeKeys = array_keys(TimeType::getList());
            $validator = Validator::make($request->all(), [
                'date' => [
                    'required',
                    'date',
                    function ($attr, $val, $fail) {
                        $startOfWeek = now()->today();
                        $endOfWeek = now()->endOfWeek();
                        $dateTime = \Carbon\Carbon::parse($val);
                        // Kiểm tra nếu $dateTime không nằm trong khoảng từ ngày bắt đầu đến ngày kết thúc của tuần hiện tại
                        if (!$dateTime->between($startOfWeek, $endOfWeek)) {
                            $fail('Chỉ có thể chọn ngày trong tuần');
                        }
                    },
                    Rule::unique('bookings', 'date')->where(function ($query) use ($user_id) {
                        return $query->where('user_id', $user_id);
                    })
                ],
                'timeType' => [
                    'required',
                    function ($attr, $val, $fail) use ($timeTypeKeys) {
                        if (!empty(array_diff($val, $timeTypeKeys))) {
                            $fail('Khung giờ không hợp lệ');
                        }
                    }
                ],
            ], [
                'date.required' => 'Bạn hãy chọn ngày đăng kí lịch làm',
                'date.date' => 'Phải là kiểu dữ liệu ngày tháng',
                'date.unique' => 'Lịch làm này đã được đăng kí',
                'timeType.required' => 'Bạn hãy chọn khung giờ đăng kí lịch làm',
                'timeType.in' => 'Khung giờ không hợp lệ',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $timeType = implode(',', $request->input('timeType'));
            $data = [
                'id' => $this->getIdAsTimestamp(),
                'date' => $request->date('date'),
                'timeType' => $timeType,
                'user_id' => $user->id
            ];
            $booking = Booking::create($data);
            if ($booking) {
                session()->flash('success', 'Lưu trữ dữ liệu thành công!');
                return redirect()->route('bookings.list', ['user_id' => $user->id]);
            } else {
                session()->flash('error', 'Có lỗi gì đó khi update database');
                return redirect()->back()->withInput();
            }
        } else {
            session()->flash('error', 'Nhân viên không có trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }
    public function view_edit($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $title = 'Sửa lịch khám';
            return view('Admin.Bookings.edit', compact('title', 'booking'));
        } else {
            session()->flash('error', 'Lịch khám không có trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }

    public function edit(Request $request, $id)
    {
        $booking = Booking::find($id);
        if ($booking) {
            $timeTypeKeys = array_keys(TimeType::getList());
            $validator = Validator::make($request->all(), [
                'date' => [
                    'required',
                    'date',
                    function ($attr, $val, $fail) {
                        $startOfWeek = now()->today();
                        $endOfWeek = now()->endOfWeek();
                        $dateTime = \Carbon\Carbon::parse($val);
                        // Kiểm tra nếu $dateTime không nằm trong khoảng từ ngày bắt đầu đến ngày kết thúc của tuần hiện tại
                        if (!$dateTime->between($startOfWeek, $endOfWeek)) {
                            $fail('Chỉ có thể chọn ngày trong tuần');
                        }
                    },
                    Rule::unique('bookings', 'date')->where(function ($query) use ($booking) {
                        return $query->where('user_id', $booking->cust_id);
                    })->ignore($booking->id)
                ],
                'timeType' => [
                    'required',
                    function ($attr, $val, $fail) use ($timeTypeKeys) {
                        if (!empty(array_diff($val, $timeTypeKeys))) {
                            $fail('Khung giờ không hợp lệ');
                        }
                    }
                ],
            ], [
                'date.required' => 'Bạn hãy chọn ngày đăng kí lịch làm',
                'date.date' => 'Phải là kiểu dữ liệu ngày tháng',
                'date.unique' => 'Lịch làm này đã được đăng kí',
                'timeType.required' => 'Bạn hãy chọn khung giờ đăng kí lịch làm',
                'timeType.in' => 'Khung giờ không hợp lệ',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $booking->date = $request->date('date');
            $booking->timeType = implode(',', $request->input('timeType'));
            $booking->updated_at = now();
            $status = $booking->save();
            if ($status) {
                session()->flash('success', 'Lưu trữ dữ liệu thành công!');
                return redirect()->route('bookings.list', ['user_id' => $booking->user_id]);
            } else {
                session()->flash('error', 'Có lỗi gì đó khi update database');
                return redirect()->back()->withInput();
            }
        } else {
            session()->flash('error', 'Lịch khám không có trong hệ thống');
            return redirect()->route('bookings.find_list');
        }
    }
}
