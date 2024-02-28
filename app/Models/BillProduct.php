<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bills_products';
    protected $hidden = [
        'created_at',
        'updated_at',
        // 'status',
        'id'
    ];

    public function biller()
    {
        return $this->belongsTo(Biller::class, 'biller_code', 'code');
    }

    public function productTransactions()
    {
        return $this->hasMany(BillsTransaction::class, 'product_code', 'code');
    }
}
