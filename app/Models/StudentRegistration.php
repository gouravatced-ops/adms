<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class StudentRegistration extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $fillable = [
        'name', 'gender', 'category', 'date_of_birth', 'aadhaar_no', 'mobile_no', 'password', 'last_login','last_ip', 'otp_verified_at' ,'password_created_at', 'device_fingerprint',
    ];

    // Add other model methods and attributes as needed
}

