<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Schedules extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'id',
        'timeType',
        'description',
        'status',
        'animal_id',
        'customer_id',
        'booking_id',
        'user_id',
    ];

    public function scopeWhereUser(Builder $query, $user_id = null): void
    {
        if (!empty($user_id)) {
            $query->where('user_id', $user_id);
        }
    }
    public function scopeWhereClinic(Builder $query, $clinic_id = null): void
    {
        if (!empty($clinic_id)) {
            $query->whereHas('user', function ($query) use ($clinic_id){
                $query->where('clinic_id',$clinic_id);
            });
        }
    }
    public function scopeWhereCustomer(Builder $query, $customer = null): void
    {
        if (!empty($customer)) {
            $customer = strtolower($customer);
            $query->whereHas('customer', function ($query) use ($customer) {
                $query->whereRaw('LOWER(email) LIKE ?', '%' . $customer . '%')
                    ->orWhereRaw('LOWER(name) LIKE ?', '%' . $customer . '%')
                    ->orWhereRaw('LOWER(phone) LIKE ?', '%' . $customer . '%')
                    ->orWhere('id', '=', intval($customer));
            });
        }
    }
    public function scopeDateFilter(Builder $query, $start_date = null, $end_date = null): void
    {
        if (!empty($start_date) || !empty($end_date)) {
            $query->whereHas('booking', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            });
        }
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
