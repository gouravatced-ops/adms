<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Admin extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'mobile_no',
        'alt_mobile_no',
        'email_id',
        'password',
        'gender',
        'admin_name',
        'profile_path',
        'prev_password',
        'role',
        'division_id',
        'designation',
        'otp_verified_at',
        'password_created_at',
    ];

    protected $casts = [
        'password_created_at' => 'datetime',
    ];

    public function isPasswordExpired(): bool
    {
        if (!$this->password_created_at) {
            return true;
        }

        return Carbon::parse($this->password_created_at)->diffInDays(now()) >= 30;
    }
}