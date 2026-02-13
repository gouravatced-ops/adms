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
        'admin_details_id',
        'mobile_no',
        'alt_mobile_no',
        'email_id',
        'password',
        'prev_password',
        'role',
        'otp_verified_at',
        'password_created_at',
    ];

    public function adminDetails()
    {
        return $this->belongsTo(AdminDetails::class, 'admin_details_id');
    }
}


