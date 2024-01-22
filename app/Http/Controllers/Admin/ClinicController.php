<?php

namespace App\Http\Controllers\Admin;
use App\Helper\Provinces;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    private const PER_PAGE = 10;

    public function __construct()
    {
    }
    public function list(Request $request){
        $title = "Danh sách phòng khám";
        $filter = collect($request->input('filter', []));
        $limit = $request->input('limit', self::PER_PAGE);
        $clinics = Clinic::paginate($limit);
        return view('Admin.Clinic.list', compact('title', 'clinics', 'filter'));
    }
    public function view_add()
    {
        $title = "Thêm phòng khám";

        $province = new Provinces();
        dd($province->getAllDistrict());


        return view('Admin.Clinic.add', compact('title'));
    }
}