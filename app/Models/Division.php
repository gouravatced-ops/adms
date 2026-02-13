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
        'status'
    ];

    public function subdivisions()
    {
        return $this->hasMany(SubDivision::class, 'division_id');
    }
}
