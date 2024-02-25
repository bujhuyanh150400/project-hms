<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMaterial extends Model
{
    use HasFactory;

    protected $table =  'type_material';
    protected $fillable = [
        'id',
        'name',
        'description',
        'is_deleted',
        'created_at',
        'updated_at',
    ];
    public function warehouse()
    {
        return $this->hasMany(WareHouse::class);
    }
}
