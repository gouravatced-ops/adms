<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCertificateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_application_id',
        'certificate_type',
        'cert_start_date',
        'cert_expiry_date',
    ];

    protected $dates = [
        'cert_start_date',
        'cert_expiry_date',
    ];

    public function studentApplication()
    {
        return $this->belongsTo(StudentApplication::class);
    }
}