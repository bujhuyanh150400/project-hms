<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PermissionAdmin;
use App\Helper\SchedulesStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\History;
use App\Models\Schedules;
use App\Models\Specialties;
use App\Models\User;
use App\Models\WareHouse;
use App\Models\WareHouseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SchedulesController extends Controller
{
    //
    const PER_PAGE = 10;

    public function find_list(Request $request)
    {
        $title = 'Tìm kiếm lịch khám bệnh';
        $filter = collect($request->input('filter', []));
        if ($this->getUserLogin()->permission === PermissionAdmin::MANAGER) {
            $filter->put('clinic_id', $this->getUserLogin()->clinic_id);
        }
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
            'status' => SchedulesStatus::ON_SCHEDULES,
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

    public function view(Request $request, $schedule_id)
    {
        $schedule = Schedules::find($schedule_id);
        if ($schedule) {
            $title = 'Chi tiết lịch khám';
            $warehouses = WareHouse::ClinicFilter($schedule->user->clinic_id)
                ->where('total', '>', 0)
                ->get();
            return view('Admin.Schedules.view', compact('title', 'schedule', 'warehouses'));
        } else {
            session()->flash('error', 'Không tìm thấy lịch khám này');
            return redirect()->route('admin.dashboard');
        }
    }

    public function submit_history(Request $request, $schedule_id)
    {
        $schedule = Schedules::find($schedule_id);
        if ($schedule) {
            $validator = Validator::make($request->all(), [
                'price' => 'required|integer',
                'warehouse' => ['required', function ($attribute, $value, $fail) {
                    foreach ($value as $warehouse_id => $total) {
                        $warehouse = WareHouse::find($warehouse_id);
                        if (!$warehouse->exists()) {
                            $fail('Có thuốc khám không tồn tại trong kho');
                            break;
                        }
                        if (intval($total) > $warehouse->total) {
                            $fail('Vật tư ' . $warehouse->name . ' Không đủ số dư');
                            break;
                        }
                    }
                }],
            ], [
                'price.required' => 'Giá không được bỏ trống',
                'price.integer' => 'Giá phải là số nguyên',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = [
                'id' => $this->getIdAsTimestamp(),
                'description_animal' => $request->input('description_animal'),
                'prescription' => $request->input('prescription'),
                'price' => $request->integer('price'),
                'schedule_id' => $schedule_id,
                'animal_id' => $schedule->animal_id,
            ];
            if ($request->hasFile('file')) {
                $fileName = 'file_' . $data['id'] . $request->file('file')->getClientOriginalName();
                $filePath = self::FILE_PATH;
                $Path = $request->file('file')->storeAs($filePath, $fileName);
                $data['file'] = base64_encode($Path);
            }
            $result = History::create($data);
            if ($result) {
                if ($request->has('warehouse')) {
                    foreach ($request->input('warehouse') as $warehouseId => $quantity) {
                        $warehouse = Warehouse::find($warehouseId);
                        if ($warehouse) {
                            $warehouse->histories()->attach($data['id']);
                            $warehouse->total = $warehouse->total - intval($quantity);
                            $data_log = [
                                'id' => $this->getIdAsTimestamp(),
                                'description' => 'Bác sĩ ' . $schedule->user->name . ' Đã dùng số lượng ' . $quantity . ' Cho buổi khám',
                                'user_id' => $schedule->user_id,
                                'warehouse_id' => $warehouse->id,
                            ];
                            WareHouseLog::create($data_log);
                            $warehouse->save();
                        }
                    }
                }
                $schedule->status = SchedulesStatus::SUCCESS;
                $schedule->save();
                session()->flash('success', 'Không tìm thấy lịch khám này');
                return redirect()->route('schedules.list', ['user_id' => $schedule->user_id]);
            }
        } else {
            session()->flash('error', 'Không tìm thấy lịch khám này');
            return redirect()->route('admin.dashboard');
        }
    }

    public function all_schedules(Request $request)
    {
        $title = 'Chi tiết lịch khám';
        $filter = $request->input('filter', []);
        if (!isset($filter['start_date_create'])) {
            $filter['start_date_create'] = now()->startOfWeek();
        };
        if (!isset($filter['end_date_create'])) {
            $filter['end_date_create'] = now()->endOfWeek();
        };
        $clinic_id = $this->getUserLogin()->clinic_id;
        $schedules = Schedules::WhereClinic($clinic_id)
            ->whereCustomer($filter['customer'] ?? null)
            ->DateFilter([$filter['start_date_create'], $filter['end_date_create']])
            ->paginate(self::PER_PAGE);
        return view('Admin.Schedules.all_schedules', compact('schedules', 'filter', 'title'));
    }

    public function change_status(Request $request)
    {
        $schedule = Schedules::find($request->integer('id'));
        if ($schedule->exists()) {
            $validator = Validator::make($request->all(), [
                'id' => ['required', function ($attribute, $value, $fail) {
                    $schedule = Schedules::find($value);
                    if (!$schedule->exists()) {
                        $fail('Không tồn tại lịch khám này');
                    } elseif (($this->getUserLogin()->permission == PermissionAdmin::DOCTOR && $schedule->user_id != $this->getUserLogin()->id)
                        || (($this->getUserLogin()->permission == PermissionAdmin::MANAGER || $this->getUserLogin()->permission == PermissionAdmin::TAKE_CARE)
                            && $schedule->user->clinic_id != $this->getUserLogin()->clinic_id)
                    ) {
                        $fail('Bạn không có quyền sửa lịch khám naày');
                    }
                }],
                'status' => ['required', function ($attribute, $value, $fail) {
                    if (!in_array(intval($value), array_keys(SchedulesStatus::getList()))) {
                        $fail('Trạng thái không hợp lệ');
                    }
                    if ($this->getUserLogin()->permission == PermissionAdmin::TAKE_CARE || $this->getUserLogin()->permission == PermissionAdmin::DOCTOR) {
                        if (intval($value) === SchedulesStatus::FAILED || intval($value) === SchedulesStatus::SUCCESS) {
                            $fail('Bạn không có quyền sửa trạng thái này');
                        }
                    }
                    if ( $this->getUserLogin()->permission == PermissionAdmin::DOCTOR) {
                        if (intval($value) === SchedulesStatus::HAS_PAYMENT) {
                            $fail('Bạn không có quyền sửa trạng thái này');
                        }
                    }
                }],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            if ($schedule->booking->date < now()->today()) {
                return response()->json(['errors' => ['status' => ['Bạn không thể sửa lịch trong quá khứ']]], 422);
            }
            $schedule->status = $request->integer('status');
            $schedule->save();
            return response()->json(['messages' => 'Thay đổi trạng thái thành công']);
        } else {
            return response()->json(['errors' => ['status' => ['Không tồn tại lich khám này']]], 422);
        }
    }
}
