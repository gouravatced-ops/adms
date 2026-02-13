<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterAllottee extends Model
{
    use HasFactory;
    protected $table = 'register_allottees';
    protected $fillable = [
        'register_id',
        'division_id',
        'sub_division_id',
        'area',
        'pcategory_id',
        'p_type_id',
        'property_number',
        'quarter_type',
        'allottee_name',
        'remarks',
    ];
}
