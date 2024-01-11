<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersController\AddRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
            ->CreatedAtFilter($filter->get('start_date_create') ?? '', $filter->get('end_date_create'))
            ->paginate($limit);
        return view('Admin.Users.list', compact('title', 'users', 'filter'));
    }

    public function view_add(){
        $title = "Thêm nhân sự";
        return view('Admin.Users.add',compact('title'));
    }
    public function add(AddRequest $request){
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
            'address' => $request->input('address'),
            'permission' => $request->input('permission'),
            'phone' => $request->input('phone'),
            'birth' =>  date('Y-m-d', strtotime($request->input('birth'))),
            'gender' => $request->input('gender'),
            'created_by' => Auth::guard('admin')->user()->id,
        ];
        if ($request->hasFile('avatar')){
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
            session()->flash('error', 'Có lỗi gì đó khi inset database');
            return redirect()->back()->withInput();
        }
    }

    public function view_edit($id){
        $user = User::find($id);
        if ($user) {
            $title = "Chỉnh sửa nhân sự";
            return view('Admin.Users.edit',compact('user','title'));
        } else {
            session()->flash('error', 'Nhân sự không tồn tại.');
            return redirect()->route('users.list');
        }
    }

    public function edit(Request $request){
        dd($request->all());
    }
}
