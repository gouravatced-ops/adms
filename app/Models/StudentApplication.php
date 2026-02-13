<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'acknowledgment_no',
        'course_type',
        'course_id',
        'other_course',
        'college_name',
        'jh_other_college_name',
        'course_registration_no',
        'name',
		'guardian_type',
        'father_name',
        'gender',
        'category',
        'address',
        'state',
        'city',
        'pin_code',
        'country',
        'mobile_no',
        'alternate_mobile_no',
        'whatsapp_no',
        'email',
        'aadhaar',
        'status',
        'council_regn_no',
        'noc_state_council',
        'form-submission-date',
        'auth_status',
        'auth_action_date',
        'auth_reject_reason',
        'auth',
        'accepted_datetime'
    ];

    protected $casts = [
        'form-submission-date' => 'datetime',
    ];

    // Optionally, if you're using accessor to rename it
    public function getFormSubmissionDateAttribute()
    {
        return $this->attributes['form-submission-date'];
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_application_id');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(UploadedDocument::class, 'student_application_id');
    }
}
