<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotteeMasterDocument extends Model
{
    use HasFactory;

    protected $table = 'allottee_master_documents';

    public $timestamps = true;

    protected $fillable = [
        'allottee_id',
        'register_allottee_id',
        'property_number',
        'file_label',
        'confirm_received',
        'confirm_same_allottee_name',
        'file_path',
        'file_name',
        'read_file',
        'is_checked',
        'checked_at',
        'is_read_divisional',
        'is_approved_divisional',
        'approved_at',
        'uploaded_at',
        'reuploaded_at',
    ];

    protected $casts = [
        'read_file' => 'boolean',
        'is_checked' => 'boolean',
        'is_read_divisional' => 'boolean',
        'is_approved_divisional' => 'boolean',

        'checked_at' => 'datetime',
        'approved_at' => 'datetime',
        'uploaded_at' => 'datetime',
        'reuploaded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'confirm_received' => 'No',
        'confirm_same_allottee_name' => 'No',
        'read_file' => 0,
        'is_checked' => 0,
        'is_read_divisional' => 0,
        'is_approved_divisional' => 0,
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (VERY USEFUL)
    |--------------------------------------------------------------------------
    */

    public function scopeChecked($query)
    {
        return $query->where('is_checked', 1);
    }

    public function scopePending($query)
    {
        return $query->where('is_checked', 0);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved_divisional', 1);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships (optional but recommended)
    |--------------------------------------------------------------------------
    */

    public function allottee()
    {
        return $this->belongsTo(Allottee::class, 'allottee_id');
    }
}