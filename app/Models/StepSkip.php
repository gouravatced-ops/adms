<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StepSkip extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'applicant_id',
        'step_number',
        'step_name',
        'remark',
        'reason_category',
        'ip_address',
        'user_agent',
        'skiped_by',
        'skipped_at'
    ];

    protected $casts = [
        'skipped_at' => 'datetime'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
