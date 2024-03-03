<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table =  'histories';

    protected $fillable = [
        'id',
        'file',
        'description_animal',
        'prescription',
        'price',
        'created_at',
        'updated_at',
        'schedule_id',
        'animal_id',
    ];
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'warehouse_history', 'history_id', 'warehouse_id');
    }
}
