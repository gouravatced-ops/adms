<?php

// app/Models/OtpLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    use HasFactory;

    protected $fillable = ['login_with', 'hashed_otp', 'otp_expiration', 'status', 'send_ip', 'veified_ip', 'otp_hmac','description'];
}

