<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotAssignmentLog extends Model
{
    use HasFactory;
    protected $table = 'lot_assignment_logs';
    public $timestamps = false;

    protected $fillable = [
        'assignment_id',
        'action',
        'user_id',
    ];
}
