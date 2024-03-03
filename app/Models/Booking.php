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
        'timeTypeSelected',
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
    public function scopeFindDate(Builder $query, $date = null)
    {
        if (!empty($date)) {
            $query->where('date', $date);
        }
    }
    public function scopeSpecialtyUser(Builder $query, $specialty_id = null)
    {
        if (!empty($specialty_id)) {
            $query->whereHas('user', function ($query) use ($specialty_id) {
                $query->where('specialties_id', $specialty_id);
            });
        }
    }
    public function scopeClinicUser(Builder $query, $clinic_id = null)
    {
        if (!empty($specialty_id)) {
            $query->whereHas('user', function ($query) use ($clinic_id) {
                $query->where('clinic_id', $clinic_id);
            });
        }
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
