<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if (!empty($keyword)) {
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(email) LIKE ?', '%' . $keyword . '%')
                ->orWhereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%')
                ->orWhere('id', '=', intval($keyword));
        }
    }
    public function scopeRoleFilter(Builder $query, $role = null): void
    {
        if (!empty($role)) {
            $query->where('permission', $role);
        }
    }
    public function scopeClinicFilter(Builder $query, $clinic_id = null): void
    {
        if (!empty($clinic_id)) {
            $query->where('clinic_id', $clinic_id);
        }
    }
    public function scopeCreatedAtFilter(Builder $query, $start_date = null, $end_date = null): void
    {
        if (!empty($start_date) || !empty($end_date)) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    }
    public function scopeBookingDateFilter(Builder $query, $date): void
    {
        $query->whereHas('booking', function ($query) use ($date) {
            $query->where('date', $date);
        });
    }
    public function scopeBookingDateFilterBetween(Builder $query, $start_date = null, $end_date = null): void
    {
        if (!empty($start_date) || !empty($end_date)) {
            $query->whereHas('booking', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            });
        }
    }
    public function scopeSpecialtyFilter(Builder $query, $id = null): void
    {
        if (!empty($id)) {
            $query->whereHas('specialties', function ($query) use ($id) {
                $query->where('id', $id);
            });
        }
    }

    protected $fillable = [
        'id',
        'email',
        'name',
        'password',
        'address',
        'permission',
        'phone',
        'birth',
        'gender',
        'created_by',
        'updated_by',
        'avatar',
        'clinic_id',
        'description',
        'examination_price',
        'user_status',
        'specialties_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    public function specialties()
    {
        return $this->belongsTo(Specialties::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    function warehouse_log()
    {
        return $this->hasMany(WarehouseLog::class);
    }
}
