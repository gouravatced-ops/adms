<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allottee extends Model
{
    use HasFactory;
    protected $table = 'allottees';
    public $timestamps = true;

    protected $fillable = [
        'scheme_id',
        'application_no',
        'application_date',
        'allotment_no',
        'allotment_date',
        'prefix',
        'allottee_name',
        'allottee_middle_name',
        'allottee_surname',
        'allottee_prefix_hindi',
        'allottee_name_hindi',
        'allottee_middle_hindi',
        'allottee_surname_hindi',
        'allottee_relation_type',
        'relation_name',
        'marital_status',
        'allottee_gender',
        'pan_card_number',
        'aadhar_card_number',
        'allottee_category',
        'date_of_birth',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function subDivision()
    {
        return $this->belongsTo(SubDivision::class, 'subdivision_id');
    }

    public function propertyCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'pcategory_id');
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function propertySubType()
    {
        return $this->belongsTo(PropertyMainType::class, 'property_subtype_id');
    }

    public function quarterType()
    {
        return $this->belongsTo(QuarterType::class, 'quarter_id');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
