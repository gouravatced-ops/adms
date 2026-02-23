<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'marital_status',
        'gender',
        'pan_card_number',
        'aadhar_card_number',
        'email',
        'login_id',
        'date_of_birth',
        'fathers_name',
        'full_name_hindi',
        'annual_income',
        'present_address',
        'post_office',
        'police_station',
        'state',
        'district',
        'pin_code',
        'mobile_number',
        'nominee_name',
        'nominee_relationship',
        'nominee_pan_card',
        'nominee_aadhaar',
        'family_details',
        'bank_name',
        'bank_account_no',
        'bank_branch', 
    ];
}
