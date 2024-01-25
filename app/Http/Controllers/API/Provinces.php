<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvincesResource;
use Illuminate\Http\Request;
use App\Helper\Provinces as ProvincesHelper;
use Illuminate\Support\Facades\Validator;

class Provinces extends Controller
{
    private mixed $provincesHelper;
    public function __construct()
    {
        $this->provincesHelper = new ProvincesHelper();
    }

    public function getProvinces(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()['id'][0]], 404);
        }
        if (empty(trim($request->input('id')))){
            $provinces = $this->provincesHelper->getAllProvince();
        }else{
            $provinces = $this->provincesHelper->getProvinceByCode(trim($request->input('id')));
        }
        return ProvincesResource::collection($provinces)->additional(['resource_type' => ProvincesHelper::PROVINCES]);
    }

    public function getDistricts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()['id'][0]], 404);
        }

        $districts = $this->provincesHelper->getDistrictByProvice($request->input('id'));
        return ProvincesResource::collection($districts)->additional(['resource_type' => ProvincesHelper::DISTRICTS]);
    }
    public function getWards(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->getMessages()['id'][0]], 404);
        }

        $wards = $this->provincesHelper->getWardByDistrict($request->input('id'));
        return ProvincesResource::collection($wards)->additional(['resource_type' => ProvincesHelper::WARD]);
    }
}
