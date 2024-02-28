<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SettlementBank extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'settlement_banks';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at', 'display', 'order_no', 'merchant_id'];


    public function bank()
    {
        return $this->hasOne(Bank::class, 'code', 'bank_code');
    }

    public function revenueHead()
    {
        return $this->hasOne(RevenueHead::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
