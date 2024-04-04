<?php

namespace App\Http\Controllers\Admin;

use App\Helper\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersController\AddRequest;
use App\Http\Requests\Admin\UsersController\EditRequest;
use App\Models\Clinic;
use App\Models\Specialties;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    private const PER_PAGE = 10;

    public function __construct()
    {
    }

    public function list(Request $request)
    {
        $title = "Danh sách nhân sự";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $users = User::KeywordFilter($filter->get('keyword'))
            ->RoleFilter($filter->get('role'))
            ->CreatedAtFilter($filter->get('start_date_create') ?? '', $filter->get('end_date_create') ?? '')
            ->paginate($limit);
        return view('Admin.Users.list', compact('title', 'users', 'filter'));
    }

    public function view_add()
    {
        $listClinic = Clinic::all();
        $listUserStatus = UserStatus::getList();
        $listSpecialties = Specialties::all();
        $title = "Thêm nhân sự";
        return view('Admin.Users.add', compact('title', 'listClinic', 'listUserStatus', 'listSpecialties'));
    }

    public function add(AddRequest $request)
    {
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
            'permission' => $request->input('permission'),
            'phone' => $request->input('phone'),
            'birth' => date('Y-m-d', strtotime($request->input('birth'))),
            'gender' => $request->input('gender'),
            'description' => $request->input('description'),
            'clinic_id' => $request->integer('clinic_id'),
            'examination_price' => $request->integer('examination_price'),
            'specialties_id' => $request->integer('specialties_id'),
            'user_status' => $request->integer('user_status'),
        ];
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            // Tạo tên tệp ngắn gọn và độc đáo
            $avatarFileName = 'avatar_' . $data['id'] . '.' . $extension;
            // Lưu trữ file và lấy đường dẫn lưu trữ
            $filePath = self::FILE_PATH_ADMIN . $data['id'];
            $avatarPath = $request->file('avatar')->storeAs($filePath, $avatarFileName);
            $data['avatar'] = base64_encode($avatarPath);
        }
        $user = User::create($data);
        if ($user) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('users.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi insert database');
            return redirect()->back()->withInput();
        }
    }
    public function view($id)
    {
        $user = User::find($id);
        if ($user) {
            $title = "Chi tiết nhân sự";
            $listClinic = Clinic::all();
            $listUserStatus = UserStatus::getList();
            return view('Admin.Users.view', compact('user', 'title', 'listClinic', 'listUserStatus'));
        } else {
            session()->flash('error', 'Nhân sự không tồn tại.');
            return redirect()->route('users.list');
        }
    }
    public function view_edit($id)
    {
        $user = User::find($id);
        if ($user) {
            $listClinic = Clinic::all();
            $listUserStatus = UserStatus::getList();
            $listSpecialties = Specialties::all();
            $title = "Chỉnh sửa nhân sự";
            return view('Admin.Users.edit', compact('user', 'title', 'listClinic', 'listUserStatus', 'listSpecialties'));
        } else {
            session()->flash('error', 'Nhân sự không tồn tại.');
            return redirect()->route('users.list');
        }
    }

    public function edit(EditRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            session()->flash('error', 'Không tìm thấy người dùng!');
            return redirect()->route('users.list');
        }
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->birth = $request->input('birth');
        $user->gender = $request->input('gender');
        $user->clinic_id = $request->integer('clinic_id');
        $user->specialties_id = $request->integer('specialties_id');
        $user->user_status = $request->integer('user_status');
        $user->examination_price = $request->integer('examination_price');
        $user->description = $request->input('description');
        $user->updated_at = now();
        if ($request->hasFile('avatar')) {
            if (Storage::exists(base64_decode($user->avatar))) {
                // Xóa luôn tránh lưu nhiều
                Storage::delete(base64_decode($user->avatar));
            }
            $extension = $request->file('avatar')->extension();
            // Tạo tên tệp ngắn gọn và độc đáo
            $avatarFileName = 'avatar_' . $user->id . '.' . $extension;
            // Lưu trữ file và lấy đường dẫn lưu trữ
            $filePath = self::FILE_PATH_ADMIN . $user->id;
            $avatarPath = $request->file('avatar')->storeAs($filePath, $avatarFileName);
            $user->avatar = base64_encode($avatarPath);
        }
        $updateResult = $user->save();
        dd($updateResult);
        if ($updateResult) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('users.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi update database');
            return redirect()->back()->withInput();
        }
    }

    public function deleted($id)
    {
        $user = User::find($id);
        if ($user) {
            if (Auth::guard('admin')->user()->id === $user->id) {
                session()->flash('error', 'Bạn không thể xóa nick đang đăng nhập được');
                return redirect()->route('users.list');
            }
            $user->delete();
            session()->flash('success', 'Xóa nhân sự thành công.');
            return redirect()->route('users.list');
        } else {
            session()->flash('error', 'Nhân sự không tồn tại.');
            return redirect()->route('users.list');
        }
    }
}
