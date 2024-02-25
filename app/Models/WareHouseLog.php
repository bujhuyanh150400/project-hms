<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    function warehouse()
    {
        return $this->belongsTo(WareHouse::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
