<?php

namespace App\Helper;

class Provinces
{
    const PROVINCES = 'provinces';
    const DISTRICTS = 'districts';
    const WARD = 'wards';
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

    public function getProvinceByCode($code): array
    {
        return array_filter($this->province, function ($item) use ($code) {
            return intval($item['code']) == $code;
        });
    }

    public function getDistrictByCode($code): array
    {
        return array_filter($this->district, function ($item) use ($code) {
            return intval($item['code']) == $code;
        });
    }

    public function getWardByCode($code): array
    {
        return array_filter($this->ward, function ($item) use ($code) {
            return intval($item['code']) == $code;
        });
    }

    public function getDistrictByProvice($code): array
    {
        return array_filter($this->district, function ($item) use ($code) {
            return intval($item['parent_code']) == $code;
        });
    }

    public function getWardByDistrict($code): array
    {
        return array_filter($this->ward, function ($item) use ($code) {
            return intval($item['parent_code']) == $code;
        });
    }
}
