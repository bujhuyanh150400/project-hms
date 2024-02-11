<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specialties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SpecialtiesController extends Controller
{
    private const PER_PAGE = 10;
    public function __construct()
    {
    }
    public function list(Request $request)
    {
        $title = 'Danh sách chuyên khoa';
        $title = "Danh sách phòng khám";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $specialties = Specialties::keywordFilter($filter->get('keyword'))->activeFilter($filter->get('active'))->paginate($limit);
        return view('Admin.Specialties.list', compact('title', 'filter', 'specialties'));
    }
    public function view_add()
    {
        $title = 'Tạo mới chuyên khoa';
        return view('Admin.Specialties.add', compact('title'));
    }
    function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'active' => 'required|in:1,2',
        ], [
            'name.required' => 'Vui lòng nhập tên chuyên khoa',
            'description.required' => 'Vui lòng nhập Mô tả nội dung',
            'active.required' => 'Vui lòng chọn trạng thái',
            'active.in' => 'Bạn đang cố tình chọn sai trạng thái',
            'logo.image' => 'Phải là ảnh',
            'logo.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg',
            'logo.max' => 'File tối đa 2048KB',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'name' => $request->input('name'),
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
            $real_path = $request->file('logo')->storeAs($filePath, $fileName);
            $data['logo'] = base64_encode($real_path);
        }
        $specialties = Specialties::create($data);
        if ($specialties) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('specialties.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi insert database');
            return redirect()->back()->withInput();
        }
    }
    public function view_edit($id)
    {
        $specialty = Specialties::find($id);
        if ($specialty) {
            $title = "Chỉnh sửa chuyên khoa";
            return view('Admin.Specialties.edit', compact('specialty', 'title'));
        } else {
            session()->flash('error', 'Chuyên khoa không tồn tại.');
            return redirect()->route('Specialty.list');
        }
    }
    public function edit(Request $request, $id)
    {
        $specialty = Specialties::find($id);
        if (!$specialty) {
            session()->flash('error', 'Không tìm thấy phòng khám!');
            return redirect()->route('clinic.list');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'active' => 'required|in:1,2',
        ], [
            'name.required' => 'Vui lòng nhập tên cơ sở',
            'description.required' => 'Vui lòng nhập Mô tả nội dung',
            'active.required' => 'Vui lòng chọn trạng thái',
            'active.in' => 'Bạn đang cố tình chọn sai trạng thái',
            'logo.image' => 'Phải là ảnh',
            'logo.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg',
            'logo.max' => 'File tối đa 2048KB',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->active = $request->input('active');
        $specialty->updated_by = Auth::guard('admin')->user()->id;
        $specialty->updated_at = now();
        if ($request->hasFile('logo')) {
            if (Storage::exists(base64_decode($specialty->logo))) {
                // Xóa luôn tránh lưu nhiều
                Storage::delete(base64_decode($specialty->logo));
            }
            $extension = $request->file('logo')->extension();
            // Tạo tên tệp ngắn gọn và độc đáo
            $fileName = $specialty->id . '.' . $extension;
            // Lưu trữ file và lấy đường dẫn lưu trữ
            $filePath = self::FILE_PATH_ADMIN . $specialty->id;
            $real_path = $request->file('logo')->storeAs($filePath, $fileName);
            $specialty->logo = base64_encode($real_path);
        }
        $updateResult = $specialty->save();
        if ($updateResult) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            return redirect()->route('specialties.list');
        } else {
            session()->flash('error', 'Có lỗi gì đó khi update database');
            return redirect()->back()->withInput();
        }
    }
    public function deleted($id)
    {
        $specialty = Specialties::find($id);
        if ($specialty) {
            $specialty->delete();
            session()->flash('success', 'Xóa phòng khám thành công.');
            return redirect()->route('specialties.list');
        } else {
            session()->flash('error', 'Phòng khám không tồn tại.');
            return redirect()->route('specialties.list');
        }
    }
}
