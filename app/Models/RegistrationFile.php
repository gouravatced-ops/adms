<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationFile extends Model
{
    use HasFactory;
    protected $table = 'file_registrations';
    public $timestamps = false;


    public function allottees()
    {
        return $this->hasMany(
            RegisterAllottee::class,
            'register_id',     // Foreign key in register_allottees
            'register_no'      // Local key in registration_files
        );
    }

    public function creator()
    {
        return $this->belongsTo(StudentRegistration::class, 'created_by');
    }

    public function scannedBy()
    {
        return $this->belongsTo(StudentRegistration::class, 'scanned_by');
    }

    public function updater()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
