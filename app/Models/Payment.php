<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_application_id',
        'passing_state',
        'other_state',
        'category',
        'registration_no',
        'result_date',
        'payment_receipt_no',
        'amount',
        'dated',
        'payment_receipt',
        'user_uploaded_document_path',
        'doc_status',
        'revert_reason',
        'revert_by',
        'stu_revert_date',
        'actionDate'
    ];

    public function studentApplication()
    {
        return $this->belongsTo(StudentApplication::class);
    }
}
