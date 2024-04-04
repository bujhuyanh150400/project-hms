<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Helper\Provinces;
use App\Helper\TypeAnimal;
use App\Models\Animal;
use App\Models\Customer;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    private const PER_PAGE = 10;

    private Provinces $provinces;

    public function __construct()
    {
        $this->provinces = new Provinces();
    }
    public function list(Request $request)
    {
        $title = "Danh sách khách hàng";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $customers = Customer::KeywordFilter($filter->get('keyword'))
            ->CreatedAtFilter($filter->get('start_date_create') ?? '', $filter->get('end_date_create'))
            ->paginate($limit);
        return view('Admin.Customer.list', compact('title', 'filter', 'customers'));
    }
    public function view_add()
    {
        $title = "Thêm khách hàng";
        return view('Admin.Customer.add', compact('title'));
    }
    public function add(Request $request)
    {
        $province = $this->provinces->getProvinceByCode($request->input('province'));
        $district = $this->provinces->getDistrictByCode($request->input('district'));
        $ward = $this->provinces->getWardByCode($request->input('ward'));
        $rule = [
            'email' => ['required', 'email', Rule::unique('customer')],
            'name' => 'required',
            'phone' => ['required', 'numeric', Rule::unique('customer')],
            'birth' => 'required|date',
            'gender' => 'required|in:1,2',
            'description' => 'nullable|min:5',
            'province' => ['required', function ($attribute, $value, $fail) use ($province) {
                if (empty($province)) {
                    $fail("Không tìm thấy Tỉnh thành phù hợp");
                }
            }],
            'district' => ['required', function ($attribute, $value, $fail) use ($district, $province) {
                if (empty($district)) {
                    $fail("Không tìm thấy Quận Huyện phù hợp");
                } elseif (reset($district)['parent_code'] != reset($province)['code']) {
                    $fail("Quận huyện này không thuộc tỉnh thành bạn chọn");
                }
            }],
            'ward' => ['required', function ($attribute, $value, $fail) use ($district, $ward) {
                if (empty($ward)) {
                    $fail("Không tìm thấy Xã phường phù hợp");
                } elseif (reset($ward)['parent_code'] != reset($district)['code']) {
                    $fail("Xã phường này không thuộc Quận huyện bạn chọn");
                }
            }],
            'address' => 'required',
        ];
        $messageError = [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại trong hệ thống.',
            'name.required' => 'Vui lòng nhập tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.unique' => 'SĐT đã tồn tại trong hệ thống.',
            'birth.required' => 'Vui lòng nhập ngày sinh.',
            'birth.date' => 'Ngày sinh không hợp lệ.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'description.min' => 'Hãy nhập ít nhất 5 kí tự',
            'province.required' => 'Vui lòng nhập Tỉnh thành',
            'district.required' => 'Vui lòng nhập Quận huyện',
            'ward.required' => 'Vui lòng nhập Xã phường',
            'address.required' => 'Vui lòng nhập Địa chỉ chi tiết',
        ];
        if ($request->has('member_register') && $request->boolean('member_register') === true) {
            $rule['password'] = 'required|min:8|max:36';
            $rule['conf_pass'] = 'required|min:8|max:36|same:password';
            $messageError['password.required'] = 'Vui lòng nhập mật khẩu.';
            $messageError['password.min'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
            $messageError['password.max'] = 'Mật khẩu không được vượt quá 36 ký tự.';
            $messageError['conf_pass.required'] = 'Vui lòng nhập lại mật khẩu.';
            $messageError['conf_pass.min'] = 'Mật khẩu xác nhận phải có ít nhất 8 ký tự.';
            $messageError['conf_pass.max'] = 'Mật khẩu xác nhận không được vượt quá 36 ký tự.';
            $messageError['conf_pass.same'] = 'Mật khẩu xác nhận không trùng khớp với mật khẩu.';
        }
        $validatorCustomer = Validator::make($request->all(), $rule, $messageError);
        if ($validatorCustomer->fails()) {
            return redirect()->back()->withErrors($validatorCustomer)->withInput();
        } else {
            $dataCustomer = [
                'id' => $this->getIdAsTimestamp(),
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'birth' => date('Y-m-d', strtotime($request->input('birth'))),
                'gender' => $request->input('gender'),
                'description' => $request->has('description') ? $request->input('description') : null,
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'ward' => $request->input('ward'),
                'address' => $request->input('address'),
            ];
            $customer = Customer::create($dataCustomer);
            if (!$customer) {
                session()->flash('error', 'Có lỗi khi thêm khách hàng.');
                return redirect()->back()->withInput();
            }
            if ($request->has('member_register') && $request->boolean('member_register')) {
                $dataMember = [
                    'id' => $this->getIdAsTimestamp(),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'password' => Hash::make($request->input('password')),
                    'customer_id' => $customer->id,
                ];
                $member = Member::create($dataMember);
                if (!$member) {
                    session()->flash('error', 'Có lỗi khi thêm thành viên.');
                    return redirect()->back()->withInput();
                }
            }
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('animal.view_add', ['cust_id' => $customer->id]);
        }
    }
    public function view($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $title = 'Chi tiết khách hàng';
             return view('Admin.Customer.add_animal', compact('title'));
        } else {
            session()->flash('error', 'Khách hàng không có trong hệ thống');
            return redirect()->route('customer.list');
        }
    }
}
