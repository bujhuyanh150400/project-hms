<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;
    protected $table =  'warehouses';
    protected $fillable = [
        'id',
        'name',
        'description',
        'total',
        'created_at',
        'updated_at',
        'clinic_id',
        'type_material_id',
        'file',
        'avatar'
    ];

    function type_material()
    {
        return $this->belongsTo(TypeMaterial::class);
    }
    function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    function warehouse_log()
    {
        return $this->hasMany(WarehouseLog::class);
    }
}
