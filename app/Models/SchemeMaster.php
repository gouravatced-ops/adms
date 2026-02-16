<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SchemeMaster extends Model
{
    use HasFactory;

    protected $table = 'scheme_master';
    protected $primaryKey = 'scheme_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'division_id',
        'sub_division_id',
        'pcategory_id',
        'p_type_id',
        'p_sub_type_id',
        'quarter_type_id',
        'scheme_name',
        'scheme_name_hindi',
        'scheme_code',
        'total_units',
        'area_sqft',
        'dimensions',
        'arms',
        'scheme_value',
        'down_payment_percentage',
        'application_deposit_amount',
        'extra_amount',
        'registry_time_deposit',
        'emi_count',
        'emi_amount',
        'down_payment_amount',
        'compound_interest_rate',
        'late_compound_interest_rate',
        'administrative_charges',
        'lease_period',
        'scheme_start_date',
        'scheme_end_date',
        'status',
        'is_active',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'arms' => 'array',
        'total_units' => 'integer',
        'area_sqft' => 'decimal:2',
        'scheme_value' => 'decimal:2',
        'down_payment_percentage' => 'decimal:2',
        'down_payment_amount' => 'decimal:2',
        'application_deposit_amount' => 'decimal:2',
        'extra_amount' => 'decimal:2',
        'registry_time_deposit' => 'decimal:2',
        'emi_count' => 'integer',
        'emi_amount' => 'decimal:2',
        'compound_interest_rate' => 'decimal:2',
        'late_compound_interest_rate' => 'decimal:2',
        'administrative_charges' => 'decimal:2',
        'scheme_start_date' => 'date',
        'scheme_end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'total_units' => 1,
        'down_payment_percentage' => 25.00,
        'emi_count' => 60,
        'compound_interest_rate' => 13.50,
        'late_compound_interest_rate' => 2.50,
        'administrative_charges' => 5.00,
        'extra_amount' => 0.00,
        'status' => 'draft',
        'is_active' => true,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeActiveSchemes($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('scheme_end_date')
                    ->orWhere('scheme_end_date', '>=', now());
            });
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'bg-secondary',
            'active' => 'bg-success',
            'completed' => 'bg-info',
            'cancelled' => 'bg-danger',
        ];

        return '<span class="badge ' . ($badges[$this->status] ?? 'bg-secondary') . '">' . ucfirst($this->status) . '</span>';
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active' && $this->is_active;
    }

    public function canBeActivated()
    {
        return $this->status === 'draft' && $this->scheme_start_date <= now();
    }

    public function markAsActive()
    {
        if ($this->canBeActivated()) {
            $this->update(['status' => 'active']);
            return true;
        }
        return false;
    }

    // Validation Rules
    public static function validationRules($schemeId = null)
    {
        $rules = [
            'division_id' => 'required',
            'sub_division_id' => 'required',
            'pcategory_id' => 'required',
            'p_type_id' => 'required',
            'p_sub_type_id' => 'nullable',
            'quarter_type_id' => 'nullable',

            'scheme_name' => 'required|string|max:255',
            'scheme_name_hindi' => 'nullable|string|max:1000',
            'scheme_code' => 'nullable|string|max:50',

            'total_units' => 'required|integer|min:1',

            'scheme_value' => 'required|numeric|min:1000',
            'down_payment_percentage' => 'required|numeric|min:0|max:100',
            'down_payment_amount' => 'required',
            'application_deposit_amount' => 'required',
            'extra_amount' => 'nullable|numeric|min:0',
            'registry_time_deposit' => 'required|numeric|min:0',

            'emi_count' => 'required|integer|min:1|max:240',
            'emi_amount' => 'required',
            'compound_interest_rate' => 'required|numeric|min:0|max:100',
            'late_compound_interest_rate' => 'required|numeric|min:0|max:100',
            'administrative_charges' => 'required|numeric|min:0|max:100',
            'lease_period' => 'required',
            'scheme_start_date' => 'required|date',
            'scheme_end_date' => 'nullable|date|after_or_equal:scheme_start_date',
            'is_active' => 'nullable|boolean',
        ];

        if ($schemeId) {
            $rules['scheme_name'] .= '|unique:scheme_master,scheme_name,' . $schemeId . ',scheme_id';
            $rules['scheme_code'] .= '|unique:scheme_master,scheme_code,' . $schemeId . ',scheme_id';
        } else {
            $rules['scheme_name'] .= '|unique:scheme_master,scheme_name';
            $rules['scheme_code'] .= '|unique:scheme_master,scheme_code';
        }

        return $rules;
    }


    // Calculate total payable with administrative charges
    public function getTotalPayableWithChargesAttribute()
    {
        $baseAmount = $this->down_payment_amount + ($this->emi_amount * $this->emi_count);
        $charges = $baseAmount * ($this->administrative_charges / 100);

        return $baseAmount + $charges + $this->extra_amount;
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'p_type_id');
    }

    public function blocks()
    {
        return $this->hasMany(SchemeBlock::class, 'scheme_id')
            ->where('status', 1);
    }
}
