<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Provinces;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{
    private const PER_PAGE = 10;

    private Provinces $provinces;

    public function __construct()
    {
        $this->provinces = new Provinces();
    }

    public function list(Request $request)
    {
        $title = "Danh sách phòng khám";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $clinics = Clinic::paginate($limit);
        return view('Admin.Clinic.list', compact('title', 'clinics', 'filter'));
    }

    public function view_add()
    {
        $title = "Thêm phòng khám";
        return view('Admin.Clinic.add', compact('title'));
    }

    public function add(Request $request)
    {
        $province = $this->provinces->getProvinceByCode($request->input('province'));
        $district = $this->provinces->getDistrictByCode($request->input('district'));
        $ward = $this->provinces->getWardByCode($request->input('ward'));
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'description' => 'required',
            'active' => 'required|in:1,2',
        ], [
            'name.required' => 'Vui lòng nhập tên cơ sở',
            'province.required' => 'Vui lòng nhập Tỉnh thành',
            'district.required' => 'Vui lòng nhập Quận huyện',
            'ward.required' => 'Vui lòng nhập Xã phường',
            'address.required' => 'Vui lòng nhập Địa chỉ chi tiết',
            'description.required' => 'Vui lòng nhập Mô tả nội dung',
            'active.required' => 'Vui lòng chọn trạng thái',
            'active.in' => 'Bạn đang cố tình chọn sai trạng thái',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'name'=> $request->input('name'),
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'address' => $request->input('address'),
            'description' => $request->input('description'),
            'active' => $request->input('active'),
            'created_by' => Auth::guard('admin')->user()->id,
        ];
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            // Tạo tên tệp ngắn gọn và độc đáo
            $fileName = $data['id'] . '.' . $extension;
            // Lưu trữ file và lấy đường dẫn lưu trữ
            $filePath = self::FILE_PATH_ADMIN . $data['id'];
            $real_path = $request->file('avatar')->storeAs($filePath, $fileName);
            $data['logo'] = base64_encode($real_path);
        }
        $clinic = Clinic::create($data);
        if ($clinic) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('clinic.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi inset database');
            return redirect()->back()->withInput();
        }
    }


    public function view_edit($id){
        $clinic = Clinic::find($id);
        if ($clinic) {
            $title = "Chỉnh sửa phòng khám";
            return view('Admin.Clinic.edit', compact('clinic', 'title'));
        } else {
            session()->flash('error', 'Phòng khám không tồn tại.');
            return redirect()->route('clinic.list');
        }
    }



}
