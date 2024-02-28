<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillsTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bills_transactions';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(BillProduct::class, 'product_code', 'code');
    }
}
