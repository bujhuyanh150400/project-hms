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


    /**
     * Tìm kiếm theo keyword (name - email)
     * @param Builder $query
     * @param  $keyword
     * @return void
     */
    public function scopeKeywordFilter(Builder $query, $keyword = null): void
    {
        if(!empty($keyword)){
            $keyword = strtolower($keyword);
            $query->whereRaw('LOWER(email) LIKE ?', '%' . $keyword . '%')
                ->orWhereRaw('LOWER(name) LIKE ?', '%' . $keyword . '%');
        }
    }

    /**
     * Tìm kiêm theo permssion
     * @param Builder $query
     * @param  $role
     * @return void
     */
    public function scopeRoleFilter(Builder $query, $role = null): void
    {
        if(!empty($role)){
            $query->where('permission', $role);
        }
    }

    /**
     * Tìm kiếm theo ngày tạo
     * @param Builder $query
     * @param $start_date
     * @param $end_date
     * @return void
     */
    public function scopeCreatedAtFilter(Builder $query, $start_date = null, $end_date = null): void
    {
        if(!empty($start_date) || !empty($end_date)){
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }
    }

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
