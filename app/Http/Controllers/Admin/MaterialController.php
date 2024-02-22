<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    const PER_PAGE = 10;
    public function __construct()
    {
    }

    public function type_material_list()
    {
        $title = 'Danh sách loại vật tư';
        $type_materials = TypeMaterial::paginate(self::PER_PAGE);
        return view('Admin.Material.list', compact('title', 'type_materials'));
    }
    public function type_material_view_add()
    {
        $title = "Thêm loại vật tư";
        return view('Admin.Material.add', compact('title'));
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
}
