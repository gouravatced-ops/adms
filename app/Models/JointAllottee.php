<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JointAllottee extends Model
{
    use HasFactory;
    protected $table = 'joint_allottees';

    protected $fillable = [
        'allottee_id',

        'prefix',
        'first_name',
        'middle_name',
        'last_name',

        'prefix_hindi',
        'first_name_hindi',
        'middle_name_hindi',
        'last_name_hindi',

        'gender',

        'aadhar_number',
        'pan_number',

        'other_doc_type',
        'other_doc_number',

        'created_by',
        'updated_by',
        'create_ip_address',
        'update_ip_address',
    ];

    public function allottee()
    {
        return $this->belongsTo(Allottee::class, 'allottee_id');
    }
}
