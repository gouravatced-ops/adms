<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'email',
        'whatsapp',
        'mobile_no',
        'alt_mobile_no',
        'profile_pic',
        'last_login',
        'last_ip',
    ];

    public function admin()
    {
        return $this->hasMany(AdminDetails::class);
    }
}
