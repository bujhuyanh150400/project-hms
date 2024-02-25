<?php

namespace App\Models;

use App\Helper\Provinces;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Clinic extends Model
{
    use HasFactory;
    private Provinces $provinces;

    public function __construct()
    {
        $this->provinces = new Provinces();
    }
    protected $table = 'clinic';
    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')->orWhere('id', '=', intval($keyword));
        }
    }
    public function scopeActiveFilter(Builder $query, $active = null): void
    {
        if (!empty($active)) {
            $query->where('active', $active);
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
    public function getProvinceDetailAttribute()
    {
        $provinceData = $this->getProvinceData();
        if (!empty($provinceData)) {
            return $provinceData;
        }
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
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function warehouse()
    {
        return $this->hasMany(WareHouse::class);
    }
}
