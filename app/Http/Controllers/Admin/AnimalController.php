<?php

namespace App\Http\Controllers\Admin;

use App\Helper\TypeAnimal;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AnimalController extends Controller
{
    private const PER_PAGE = 10;
    public function __construct()
    {
    }
    public function list(Request $request)
    {
        $title = "Danh sách khách hàng";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $animals = Animal::KeywordFilter($filter->get('keyword'))
            ->paginate($limit);
        return view('Admin.Animal.list', compact('title', 'filter', 'animals'));
    }
    public function find_cust(Request $request)
    {
        $title = "Thêm thú cưng - tìm kiếm khách hàng";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $customers = Customer::KeywordFilter($filter->get('keyword'))
            ->paginate($limit);
        return view('Admin.Animal.find_cust', compact('title', 'filter', 'customers'));
    }
    public function view_add($cust_id)
    {
        $customer = Customer::find($cust_id);
        if ($customer) {
            $title = 'Thêm thú cưng';
            return view('Admin.Animal.add', compact('title', 'customer'));
        } else {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('animal.list');
        }
    }

    public function add(Request $request, $cust_id)
    {
        $customer = Customer::find($cust_id);
        if ($customer) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'age' => 'required|numeric|min:0.1|max:30',
                'gender' => 'required|in:1,2',
                'species' => 'required',
                'description' => 'nullable|min:5',
                'type' => ['required', Rule::in(array_keys(TypeAnimal::getList()))],
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'Vui lòng nhập tên thú cưng.',
                'age.required' => 'Vui lòng nhập tuổi.',
                'age.numeric' => 'Tuổi phải là số.',
                'age.min' => 'Tuổi phải lớn hơn 0.',
                'age.max' => 'Không được quá 30 tuổi.',
                'gender.required' => 'Vui lòng chọn giới tính.',
                'gender.in' => 'Giới tính không hợp lệ.',
                'species.required' => 'Vui lòng nhập giống.',
                'description.min' => 'Nội dung phải lớn hơn 5 kí tự.',
                'type.required' => 'Vui lòng nhập loại động vật.',
                'type.in' => 'Kiểu không hợp lệ.',
                'avatar.image' => 'Phải là ảnh',
                'avatar.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg',
                'avatar.max' => 'File tối đa 2048KB',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $data = [
                    'id' => $this->getIdAsTimestamp(),
                    'name' => $request->input('name'),
                    'gender' => $request->input('gender'),
                    'age' => $request->input('age'),
                    'species' => $request->input('species'),
                    'type' => $request->input('type'),
                    'description' => $request->has('description') ? $request->input('description') : null,
                    'customer_id' => $customer->id,
                    'created_at' => now()
                ];
                if ($request->hasFile('avatar')) {
                    $avatarFileName = 'avatar_' . $data['id'] . '.' . $request->file('avatar')->extension();
                    // Lưu trữ file và lấy đường dẫn lưu trữ
                    $filePath = self::FILE_PATH_ADMIN . $data['id'];
                    $avatarPath = $request->file('avatar')->storeAs($filePath, $avatarFileName);
                    $data['avatar'] = base64_encode($avatarPath);
                }
                $animal = Animal::create($data);
                if ($animal) {
                    session()->flash('success', 'Lưu trữ dữ liệu thành công!');
                    if ($request->has('add_more')) {
                        return redirect()->route('animal.view_add', ['cust_id' => $customer->id]);
                    } else {
                        return redirect()->route('animal.list');
                    }
                } else {
                    session()->flash('error', 'Có lỗi gì đó khi insert database');
                    return redirect()->back()->withInput();
                }
            }
        } else {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('customer.list');
        }
    }
}
