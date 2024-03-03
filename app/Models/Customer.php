<?php

namespace App\Models;

use App\Helper\Provinces;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Customer extends Model
{
    use HasFactory;
    private Provinces $provinces;

    public function __construct()
    {
        $this->provinces = new Provinces();
    }
    protected $table =  'customer';
    protected $fillable = [
        'id',
        'email',
        'phone',
        'name',
        'province',
        'district',
        'ward',
        'address',
        'birth',
        'gender',
        'description',
    ];
    public function member()
    {
        return $this->hasOne(Member::class);
    }
    public function animal()
    {
        return $this->hasMany(Animal::class);
    }


    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(email) LIKE ?', '%' . $keyword . '%')
                ->orWhereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')
                ->orWhereRaw('LOWER(phone) LIKE ?', '%' . $keyword . '%')
                ->orWhere('id', '=', intval($keyword));
        }
    }

    public function scopeCreatedAtFilter(Builder $query, $start_date = null, $end_date = null): void
    {
        if (!empty($start_date) || !empty($end_date)) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
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
}
