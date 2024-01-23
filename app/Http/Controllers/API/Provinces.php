<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvincesResource;
use Illuminate\Http\Request;
use App\Helper\Provinces as ProvincesHelper;
use Illuminate\Support\Facades\Validator;

class Provinces extends Controller
{
    private $provincesHelper;
    public function __construct()
    {
        $this->provincesHelper = new ProvincesHelper();
    }

    public function getProvinces()
    {
        $provinces = $this->provincesHelper->getAllProvince();
        return ProvincesResource::collection($provinces)->additional(['resource_type' => ProvincesHelper::PROVINCES]);
    }

    public function getDistricts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input.'], 404);
        }

        $districts = $this->provincesHelper->getDistrictByProvice($request->input('province_code'));
        return ProvincesResource::collection($districts)->additional(['resource_type' => ProvincesHelper::DISTRICTS]);
    }
    public function getWards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'district_code' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input.'], 404);
        }

        $wards = $this->provincesHelper->getWardByDistrict($request->input('district_code'));
        return ProvincesResource::collection($wards)->additional(['resource_type' => ProvincesHelper::WARD]);
    }
}
