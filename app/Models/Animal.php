<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Animal extends Model
{
    use HasFactory;

    protected $table = 'animals';

    protected $fillable = [
        'id',
        'name',
        'gender',
        'age',
        'species',
        'avatar',
        'type',
        'description',
        'customer_id',
        'created_at',
        'updated_at'
    ];
    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')
                ->orWhere('id', '=', intval($keyword));
        }
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
