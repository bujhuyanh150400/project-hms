<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $table =  'bookings';
    protected $fillable = [
        'id',
        'timeType',
        'date',
        'updated_at',
        'user_id'
    ];
    public function scopeDateFilter(Builder $query, $start_date = null, $end_date = null): void
    {
        if (!empty($start_date) || !empty($end_date)) {
            $query->whereBetween('date', [$start_date, $end_date]);
        }
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
