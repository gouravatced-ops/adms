<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotteeDocument extends Model
{
    use HasFactory;
    protected $table = 'allottee_documents';

    protected $fillable = [
        'allottee_id',
        'document_id',
        'doc_no',
        'doc_day',
        'doc_month',
        'doc_year',
        'additional_info',
        'remarks',
        'file_path',
        'file_name',
        'is_sadmin_read',
        'is_divisional_read',
        'uploaded_by'
    ];

    public $timestamps = false;

    public function allottee()
    {
        return $this->belongsTo(Allottee::class, 'allottee_id');
    }

    public function document()
    {
        return $this->belongsTo(DocumentMaster::class, 'document_id');
    }

    public function getDocumentDateAttribute()
    {
        if (!$this->doc_day || !$this->doc_month || !$this->doc_year) {
            return null;
        }

        return $this->doc_day . '-' . $this->doc_month . '-' . $this->doc_year;
    }
}
