<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $table = 'divisions';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'division_code',
        'status'
    ];

    public function subdivisions()
    {
        return $this->hasMany(SubDivision::class, 'division_id');
    }

    public function allottees()
    {
        return $this->hasMany(Allottee::class, 'division_id');
    }
}
