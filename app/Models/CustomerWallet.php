<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Audit Log
use OwenIt\Auditing\Contracts\Auditable;

class CustomerWallet extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = "customer_wallet";
    public $incrementing = false;


    //
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
