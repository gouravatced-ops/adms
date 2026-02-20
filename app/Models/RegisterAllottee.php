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
        'prefix',
        'allottee_name',
        'remarks',
        'no_of_files',
        'no_of_supplement',
        'created_by',
        'updated_by',
        'ip_address',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class, 'sub_division_id');
    }

}