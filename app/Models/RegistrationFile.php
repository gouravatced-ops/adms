<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationFile extends Model
{
    use HasFactory;
    protected $table = 'file_registrations';
    public $timestamps = false;

    protected $fillable = [
        'division_id',
        'lots_subadmin_approved',
        'divisional_approval',
        'remarks',
        'status',
        'scanned_by',
        'created_by',
    ];


    public function allottees()
    {
        return $this->hasMany(
            RegisterAllottee::class,
            'register_id',     // Foreign key in register_allottees
            'register_no'      // Local key in registration_files
        );
    }

    public function registerAllottee()
    {
        return $this->hasMany(
            Allottee::class,
            'register_id',     // Foreign key in register_allottees
            'register_no'      // Local key in registration_files
        );
    }

    public function registerAllotteeDetails()
    {
        return $this->hasMany(
            RegisterAllottee::class,
            'register_id',     // Foreign key in register_allottees
            'register_no'      // Local key in registration_files
        )->with('allottee');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scannedBy()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function lotAssignments()
    {
        return $this->hasMany(LotAssignment::class, 'lot_id');
    }
}
