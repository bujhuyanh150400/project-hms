<?php

namespace App\Models;

use App\Helper\Provinces;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    private Provinces $provinces;

    public function __construct()
    {
        $this->provinces = new Provinces();
    }


    protected $table = 'clinic';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getAddressDataAttribute()
    {
        $provinceData = $this->getProvinceData();
        $districtData = $this->getDistrictData();
        $wardData = $this->getWardData();
        if ($provinceData && $districtData && $wardData) {
            return "{$provinceData['name_with_type']}, {$districtData['name_with_type']}, {$wardData['name_with_type']} , {$this->address}";
        } else {
            return "Không tìm thấy thông tin địa chỉ";
        }
    }

    protected function getProvinceData()
    {
        $data = $this->provinces->getProvinceByCode($this->province);
        return reset($data);
    }

    protected function getDistrictData()
    {
        $data = $this->provinces->getDistrictByCode($this->district);
        return reset($data);

    }

    protected function getWardData()
    {
        $data = $this->provinces->getWardByCode($this->ward);
        return reset($data);
    }

    protected $fillable = [
        'id',
        'name',
        'province',
        'district',
        'ward',
        'address',
        'description',
        'active',
        'updated_at',
        'created_by',
        'updated_by',
        'logo',
    ];
}
