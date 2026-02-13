<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedApplicants extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_application_id',
        'allotted_certificate_no',
        'certificate_path',
        'signed_certificate_path',
        'certficate_valid_from_date',
        'payment_receipt_no',
        'alloted_regn_no',
        'signed_uploaded_at',
        'signed_uploaded_by',
        'created_by',
        'updated_by',
    ];

    public function studentApplication()
    {
        return $this->belongsTo(StudentApplication::class);
    }
}
