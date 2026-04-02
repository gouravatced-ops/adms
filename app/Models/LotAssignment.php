<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotAssignment extends Model
{
    use HasFactory;
    protected $table = 'lot_assignments';
    public $timestamps = false;

    protected $fillable = [
        'lot_id',
        'assigned_to',
        'assigned_by',
        'assigned_at',
        'allottee_id',
        'assignment_type',
        'completed_at',
        'updated_at',
        'status'
    ];
}
