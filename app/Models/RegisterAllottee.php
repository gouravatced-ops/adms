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
        'confirm_received',
        'confirm_same_allottee_name',
        'division_id',
        'sub_division_id',
        'area',
        'pcategory_id',
        'p_type_id',
        'property_number',
        'quarter_type',
        'prefix',
        'allottee_name',
        'allottee_middle_name',
        'allottee_surname',
        'remarks',
        'no_of_files',
        'no_of_supplement',
        'parent_id',
        'grand_parent_id',
        'is_bill_generated',
        'bill_id',
        'bill_generated_at',
        'created_by',
        'updated_by',
        'is_active',
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

    public function propertyCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'pcategory_id');
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'p_type_id');
    }

    public function quarterType()
    {
        return $this->belongsTo(QuarterType::class, 'quarter_type');
    }

    public function scannedBy()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function allottee()
    {
        return $this->hasOne(\App\Models\Allottee::class, 'register_file_id', 'id');
    }

    public function registration()
    {
        return $this->belongsTo(RegistrationFile::class, 'register_id');
    }

    public function lotAssignments()
    {
        return $this->hasMany(LotAssignment::class, 'allottee_id');
    }

    public function bill()
    {
        return $this->belongsTo(INDBNKBill::class, 'bill_id');
    }

    public function billItems()
    {
        return $this->hasMany(INDBNKBillItem::class, 'allottee_id');
    }
}
