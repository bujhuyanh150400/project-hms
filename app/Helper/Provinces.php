<?php

namespace App\Helper;

class Provinces
{
    const PROVINCE_PATH = __DIR__ . '/json/provinces/tinh_tp.json';
    const DISTRICT_PATH = __DIR__ . '/json/provinces/quan_huyen.json';
    const WARD_PATH = __DIR__ . '/json/provinces/xa_phuong.json';

    private $province;
    private $district;
    private $ward;

    public function __construct()
    {
        if (file_exists(self::PROVINCE_PATH) && file_exists(self::DISTRICT_PATH) && file_exists(self::WARD_PATH)) {
            $content_provice = file_get_contents(self::PROVINCE_PATH);
            $content_district = file_get_contents(self::DISTRICT_PATH);
            $content_ward = file_get_contents(self::WARD_PATH);
            $this->province = json_decode($content_provice, true);
            $this->district = json_decode($content_district, true);
            $this->ward = json_decode($content_ward, true);
        }
    }

    public function getAllProvince(): array
    {
        return $this->province;
    }

    public function getAllDistrict(): array
    {
        return $this->district;
    }

    public function getAllWard(): array
    {
        return $this->ward;
    }

    public function getDistrictByProvice($code): array
    {
        $district = array_filter();
    }


}
