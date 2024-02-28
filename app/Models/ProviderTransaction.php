<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class ProviderTransaction extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    static $reconcilation = [
        "unreconciled" => "UNRECONCILED",
        "reconciled" => "RECONCILED",
        "over_charge" => "OVER_CHARGE",
        "under_charge" => "UNDER_CHARGE",
    ];
    static $status = [
        "approved" => "APPROVED",
        "pending" => "PENDING",
        "failed" => "FAILED",
    ];

    /**
     * Get the transaction associated with the ProviderTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_reference');
    }

    public function provider() : BelongsTo {
        return $this->belongsTo(Providers::class);
        
    }
}
