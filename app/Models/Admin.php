<?php

namespace App\Models;

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
        'otp_verified_at',
        'password_created_at',
    ];
}