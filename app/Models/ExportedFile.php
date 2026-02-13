<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportedFile extends Model
{
    use HasFactory;
    protected $table = 'exported_files';
    public $timestamps = false;
    protected $fillable = [
        'register_no',
        'file_name',
        'file_path',
        'file_size',
    ];
}
