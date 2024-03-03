<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'price',
        'avatar'
    ];
    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')
                ->orWhere('id', '=', intval($keyword));
        }
    }
    public function scopeClinicFilter(Builder $query, $clinic_id = null): void
    {
        if (!empty($clinic_id)) {
            $query->where('clinic_id', $clinic_id);
        }
    }

    public function scopeTypeFilter(Builder $query, $type = null): void
    {
        if (!empty($type)) {
            $query->where('type_material_id', $type);
        }
    }
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
    public function histories()
    {
        return $this->belongsToMany(History::class, 'warehouse_history', 'warehouse_id', 'history_id');
    }
}
