<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WareHouseLog extends Model
{
    use HasFactory;

    protected $table =  'warehouse_log';

    protected $fillable = [
        'id',
        'description',
        'warehouse_id',
        'created_at',
        'updated_at',
        'user_id',
    ];
    public function scopeWarehouseFilter(Builder $query, $warehouse_id = null): void
    {
        if (!empty($warehouse_id)) {
            $query->where('warehouse_id', $warehouse_id);
        }
    }
    function warehouse()
    {
        return $this->belongsTo(WareHouse::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
