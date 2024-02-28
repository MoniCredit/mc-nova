<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
// Audit Log
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settlement extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $hidden = ['updated_at', 'bank_data',
                        'provider_status', 'reference', 'response'];
    static $status = [
        "pending" => "PENDING",
        "processing" => "PROCESSING",
        "paid" => "PAID",
        "failed" => "FAILED",
    ];
    static $processMode = [
        "automatic" => "AUTOMATIC",
        "manual" => "MANUAL",
    ];
    static $type = [
        "affiliate" => "AFFLIATE",
        "revenue" => "REVENUE",
    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }


    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function settlementBank()
    {
        return $this->belongsTo(SettlementBank::class);
    }

    public function transactionSplit()
    {
        return $this->belongsTo(TransactionSplit::class);
    }

    /**
     * Get the split associated with the Settlement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function split()
    {
        return $this->hasOne(TransactionSplit::class);
    }
}
