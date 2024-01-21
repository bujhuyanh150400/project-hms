<?php

namespace App\Helper;

class Provinces
{
    const PROVINCE_PATH = __DIR__ . '/json/provinces/quan_huyen.json';
    const DISTRICT_PATH = __DIR__ . '/json/provinces/tinh_tp.json';
    const WARD_PATH = __DIR__ . '/json/provinces/xa_phuong.json';

    private $province;
    private $district;
    private $ward;
    public function __construct()
    {
    }

    private function init(){
        if (file_exists(self::PROVINCE_PATH) || file_exists(self::DISTRICT_PATH) || file_exists(self::WARD_PATH)){
            $content_provice = file_get_contents(self::PROVINCE_PATH);
        }
    }
    public function getList(){

    }
}
