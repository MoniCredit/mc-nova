<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

class TransactionSplit extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];


    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the settlement that owns the TransactionSplit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function settlement(): BelongsTo
    {
        return $this->belongsTo(Settlement::class);
    }

    /**
     * Get the account that owns the TransactionSplit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the settlementbank that owns the TransactionSplit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function settlement_bank(): BelongsTo
    {
        return $this->belongsTo(SettlementBank::class);
    }
}
