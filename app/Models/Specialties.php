<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Specialties extends Model
{
    use HasFactory;
    protected $table = 'specialties';

    protected $fillable = [
        'id',
        'name',
        'description',
        'active',
        'logo',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')
                ->orWhere('id', '=', intval($keyword));
        }
    }
    public function scopeActiveFilter(Builder $query, $active = null): void
    {
        if (!empty($active)) {
            $query->where('active', $active);
        }
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
