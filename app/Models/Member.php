<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table =  'member';
    protected $fillable = [
        'id',
        'email',
        'phone',
        'password',
        'customer_id',
        'updated_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];
    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
