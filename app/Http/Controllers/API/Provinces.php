<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProvincesResource;
use Illuminate\Http\Request;
use App\Helper\Provinces as ProvincesHelper;

class Provinces extends Controller
{
    private $provincesHelper;
    public function __construct()
    {
        $this->provincesHelper = new ProvincesHelper();
    }

    public function getProvinces(){
        $provinces = $this->provincesHelper->getAllProvince();
        return ProvincesResource::collection($provinces)->additional(['resource_type'=>ProvincesHelper::PROVINCES]);
    }
}
