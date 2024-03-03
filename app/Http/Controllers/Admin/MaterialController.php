<?php

namespace App\Http\Controllers\Admin;

use App\Helper\PermissionAdmin;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\TypeMaterial;
use App\Models\WareHouse;
use App\Models\WareHouseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    const PER_PAGE = 10;
    public function __construct()
    {
    }

    public function type_material_list()
    {
        $title = 'Danh sách loại vật tư';
        $type_materials = TypeMaterial::where('is_deleted', 0)->paginate(self::PER_PAGE);
        return view('Admin.TypeMaterial.list', compact('title', 'type_materials'));
    }
    public function type_material_view_add()
    {
        $title = "Thêm loại vật tư";
        return view('Admin.TypeMaterial.add', compact('title'));
    }
    public function type_material_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ], [
            'name.required' => 'Hãy nhập tên',
            'description.required' => 'Hãy nhập mô tả',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];
        $type_material = TypeMaterial::create($data);
        if ($type_material) {
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            if ($request->has('add_more')) {
                return redirect()->route('type_material.view_add');
            } else {
                return redirect()->route('type_material.list');
            }
        } else {
            session()->flash('error', 'Có lỗi gì đó khi insert database');
            return redirect()->back()->withInput();
        }
    }

    public function type_material_view_edit($id)
    {
        $type_material = TypeMaterial::find($id);
        if ($type_material) {
            $title = "Chỉnh sửa loại vật tư";
            return view('Admin.TypeMaterial.edit', compact('title', 'type_material'));
        } else {
            session()->flash('error', 'Không tìm thấy loại vật tư này');
            return redirect()->route('type_material.list');
        }
    }
    public function type_material_edit(Request $request, $id)
    {
        $type_material = TypeMaterial::find($id);
        if ($type_material) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required'
            ], [
                'name.required' => 'Hãy nhập tên',
                'description.required' => 'Hãy nhập mô tả',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $type_material->name = $request->input('name');
            $type_material->description = $request->input('description');
            $type_material->updated_at = now();
            $result_update = $type_material->save();
            if ($result_update) {
                session()->flash('success', 'Lưu trữ dữ liệu thành công!');
                return redirect()->route('type_material.list');
            } else {
                session()->flash('error', 'Có lỗi gì đó khi update database');
                return redirect()->back()->withInput();
            }
        } else {
            session()->flash('error', 'Không tìm thấy loại vật tư này');
            return redirect()->route('type_material.list');
        }
    }

    public function type_material_deleted($id)
    {
        $type_material = TypeMaterial::find($id);
        if ($type_material) {
            $type_material->is_deleted = 1;
            $result_update = $type_material->save();
            if ($result_update) {
                session()->flash('success', 'Xoá thành công!');
                return redirect()->route('type_material.list');
            } else {
                session()->flash('error', 'Có lỗi gì đó khi update database');
                return redirect()->back()->withInput();
            }
        } else {
            session()->flash('error', 'Không tìm thấy loại vật tư này');
            return redirect()->route('type_material.list');
        }
    }

    public function warehouse_list(Request $request)
    {
        $title = 'Danh sách các vật tư';
        $filter = collect($request->input('filter', []));
        if ($this->getUserLogin()->permission !== PermissionAdmin::ADMIN) {
            $filter->put('clinic', $this->getUserLogin()->clinic_id);
        }
        $warehouses = WareHouse::KeywordFilter($filter->get('keyword'))
            ->ClinicFilter($filter->get('clinic'))
            ->typeFilter($filter->get('type_material'))
            ->paginate(self::PER_PAGE);
        $type_materials = TypeMaterial::where('is_deleted', 0)->get();
        $clinics = Clinic::where('active', 1)->get();
        return view('Admin.Warehouse.list', compact('title', 'warehouses', 'clinics', 'type_materials', 'filter'));
    }
    public function warehouse_view_add()
    {
        $title = 'Thêm vật tư';
        $clinics = Clinic::where('active', 1)->get();
        $type_materials = TypeMaterial::where('is_deleted', 0)->get();
        return view('Admin.Warehouse.add', compact('title', 'clinics', 'type_materials'));
    }
    public function warehouse_add(Request $request)
    {
        if ($this->getUserLogin()->permission !== PermissionAdmin::ADMIN) {
            $request->merge(['clinic_id' => $this->getUserLogin()->clinic_id]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'total' => 'required|integer|min:0',
            'clinic_id' => ['required', Rule::exists('clinic', 'id')],
            'type_material_id' => ['required', Rule::exists('type_material', 'id')],
            'description' => 'required',
            'price' => ['required','integer','min:0'],
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4080',
            'description_log' => 'required',
        ], [
            'name.required' => 'Tên là trường bắt buộc.',
            'total.required' => 'Số lượng là trường bắt buộc.',
            'total.integer' => 'Số lượng  phải là số nguyên.',
            'total.min' => 'Số lượng  phải lớn hơn hoặc bằng 0.',
            'clinic_id.required' => 'Phòng khám là trường bắt buộc.',
            'clinic_id.exists' => 'Phòng khám không tồn tại.',
            'type_material_id.required' => 'Loại vật liệu là trường bắt buộc.',
            'type_material_id.in' => 'Loại vật liệu không tồn tại.',
            'description.required' => 'Mô tả là trường bắt buộc.',
            'avatar.image' => 'Phải là ảnh',
            'price.required' => 'Nhập giá vật tư',
            'price.integer' => 'Phải là số nguyên',
            'price.min' => 'Lớn hơn 0',
            'description_log.required' => 'Trường này là bắt buộc nhập',
            'avatar.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg,webp',
            'avatar.max' => 'File tối đa 4080KB',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = [
            'id' => $this->getIdAsTimestamp(),
            'name' => $request->input('name'),
            'total' => $request->integer('total'),
            'clinic_id' => $request->integer('clinic_id'),
            'price'=> $request->integer('price'),
            'type_material_id' => $request->integer('type_material_id'),
            'description' => $request->input('description'),
        ];
        if ($request->hasFile('file')) {
            $extension = $request->file('file')->extension();
            $fileName = 'file_' . $data['id'] . $request->file('file')->getClientOriginalName();
            $filePath = self::FILE_PATH;
            $Path = $request->file('file')->storeAs($filePath, $fileName);
            $data['file'] = base64_encode($Path);
        }
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            $fileName = 'avatar_' . $data['id'] . '.' . $extension;
            $filePath = self::FILE_PATH;
            $avatarPath = $request->file('avatar')->storeAs($filePath, $fileName);
            $data['avatar'] = base64_encode($avatarPath);
        }
        $warehouse = WareHouse::create($data);
        if ($warehouse) {
            $data_log = [
                'id' => $this->getIdAsTimestamp(),
                'description' => $request->input('description_log'),
                'user_id' => Auth::guard('admin')->user()->id,
                'warehouse_id' => $data['id']
            ];
            WareHouseLog::create($data_log);
            session()->flash('success', 'Lưu trữ dữ liệu thành công!');
            if ($request->has('add_more')) {
                return redirect()->route('warehouse.view_add');
            } else {
                return redirect()->route('warehouse.list');
            }
        } else {
            session()->flash('error', 'Có lỗi gì đó khi insert database');
            return redirect()->back()->withInput();
        }
    }

    public function warehouse_view_edit($id)
    {
        $warehouse = WareHouse::find($id);
        if ($warehouse) {
            $title = 'Sửa vật tư';
            $clinics = Clinic::where('active', 1)->get();
            $type_materials = TypeMaterial::where('is_deleted', 0)->get();
            if (!empty($warehouse->file)) {
                $path = base64_decode($warehouse->file);
                $warehouse->name_file = pathinfo($path, PATHINFO_BASENAME);
            }
            return view('Admin.Warehouse.edit', compact('title', 'clinics', 'type_materials', 'warehouse'));
        } else {
            session()->flash('error', 'Không tìm thấy vật tư này');
            return redirect()->route('warehouse.list');
        }
    }
    public function warehouse_edit(Request $request, $id)
    {
        $warehouse = WareHouse::find($id);
        if ($warehouse) {
            if ($this->getUserLogin()->permission !== PermissionAdmin::ADMIN) {
                $request->merge(['clinic_id' => $this->getUserLogin()->clinic_id]);
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'total' => 'required|integer|min:0',
                    'clinic_id' => ['required', Rule::exists('clinic', 'id')],
                    'type_material_id' => ['required', Rule::exists('type_material', 'id')],
                    'description' => 'required',
                    'price' => ['required','integer','min:0'],
                    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4080',
                    'description_log' => 'required',
                ],
                [
                    'name.required' => 'Tên là trường bắt buộc.',
                    'total.required' => 'Số lượng là trường bắt buộc.',
                    'total.integer' => 'Số lượng  phải là số nguyên.',
                    'total.min' => 'Số lượng  phải lớn hơn hoặc bằng 0.',
                    'clinic_id.required' => 'Phòng khám là trường bắt buộc.',
                    'clinic_id.exists' => 'Phòng khám không tồn tại.',
                    'type_material_id.required' => 'Loại vật liệu là trường bắt buộc.',
                    'type_material_id.in' => 'Loại vật liệu không tồn tại.',
                    'description.required' => 'Mô tả là trường bắt buộc.',
                    'avatar.image' => 'Phải là ảnh',
                    'price.required' => 'Nhập giá vật tư',
                    'price.integer' => 'Phải là số nguyên',
                    'price.min' => 'Lớn hơn 0',
                    'avatar.mimes' => 'Bạn phải chọn các file jpeg,png,jpg,gif,svg,webp',
                    'avatar.max' => 'File tối đa 4080KB',
                    'description_log.required' => 'Trường này là bắt buộc nhập',

                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $warehouse->name = $request->input('name');
            $warehouse->total = $request->integer('total');
            $warehouse->clinic_id = $request->integer('clinic_id');
            $warehouse->price = $request->integer('price');
            $warehouse->type_material_id = $request->integer('type_material_id');
            $warehouse->description = $request->input('description');
            if ($request->hasFile('file')) {
                if (Storage::exists(base64_decode($warehouse->file))) {
                    Storage::delete(base64_decode($warehouse->file));
                }
                $extension = $request->file('file')->extension();
                $fileName = 'file_' . $warehouse['id'] . $request->file('file')->getClientOriginalName();
                $filePath = self::FILE_PATH;
                $Path = $request->file('file')->storeAs($filePath, $fileName);
                $warehouse->file = base64_encode($Path);
            }
            if ($request->hasFile('avatar')) {
                if (Storage::exists(base64_decode($warehouse->avatar))) {
                    Storage::delete(base64_decode($warehouse->avatar));
                }
                $extension = $request->file('avatar')->extension();
                $fileName = 'avatar_' . $warehouse->id . '.' . $extension;
                $filePath = self::FILE_PATH;
                $avatarPath = $request->file('avatar')->storeAs($filePath, $fileName);
                $warehouse->avatar = base64_encode($avatarPath);
            }
            $status = $warehouse->save();
            if ($status) {
                $data_log = [
                    'id' => $this->getIdAsTimestamp(),
                    'description' => $request->input('description_log'),
                    'user_id' => Auth::guard('admin')->user()->id,
                    'warehouse_id' => $warehouse->id
                ];
                WareHouseLog::create($data_log);
                session()->flash('success', 'Lưu trữ dữ liệu thành công!');
                return redirect()->route('warehouse.list');
            }
        } else {
            session()->flash('error', 'Không tìm thấy vật tư này');
            return redirect()->route('warehouse.list');
        }
    }

    public function warehouse_log(Request $request, $id)
    {
        $warehouse = WareHouse::find($id);
        if ($warehouse) {
            $title = 'Log vật tư';
            $warehouse_logs = WareHouseLog::warehouseFilter($id)->paginate(self::PER_PAGE);
            return view('Admin.Warehouse.log', compact('title', 'warehouse_logs', 'warehouse'));
        } else {
            session()->flash('error', 'Không tìm thấy vật tư này');
            return redirect()->route('warehouse.list');
        }
    }

    function warehouse_view_edit_total($id)
    {
    }
    function warehouse_edit_total(Request $request, $id)
    {
    }
}
