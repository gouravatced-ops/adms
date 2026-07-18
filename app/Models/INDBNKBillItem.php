<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class INDBNKBillItem extends Model
{
    use HasFactory;
    protected $table = 'indbnk_bill_items';

    protected $fillable = [
        'bill_id',
        'allottee_id',
    ];

    // Relations

    public function bill()
    {
        return $this->belongsTo(INDBNKBill::class, 'bill_id');
    }

    public function allottee()
    {
        return $this->belongsTo(RegisterAllottee::class, 'allottee_id');
    }
}
