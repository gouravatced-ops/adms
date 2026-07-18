<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INDBNKBill extends Model
{
    use HasFactory;
    protected $table = 'indbnk_bills';

    protected $fillable = [
        'bill_no',
        'start_from',
        'end_at',
        'total_allottee',
        'generated_pdf_name',
        'generated_pdf_path',
        'remarks',
        'generated_by',
    ];

    protected $appends = ['encrypted_bill_id'];

    public function getEncryptedBillIdAttribute()
    {
        return encrypt($this->id);
    }

    // Relations

    public function billItems()
    {
        return $this->hasMany(INDBNKBillItem::class, 'bill_id');
    }

    public function allottees()
    {
        return $this->belongsToMany(
            RegisterAllottee::class,
            'indbnk_bill_items',
            'bill_id',
            'allottee_id'
        );
    }
}