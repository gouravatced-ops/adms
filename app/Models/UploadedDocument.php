<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_application_id', 'document_name', 'document_path', 'user_uploaded_document_path','stu_revert_date','status','reason','auth_id','actionDate'
    ];

    public function studentApplication()
    {
        return $this->belongsTo(StudentApplication::class);
    }
}
