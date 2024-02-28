<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;

class Aggregator extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    public $incrementing = false;

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    /**
     * The roles that belong to the Aggregator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class, 'aggregator_customers', 'aggregator_id', 'wallet_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return  Carbon::parse($value)->format('F d, Y');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return  Carbon::parse($value)->format('F d, Y');
    }

    /**
     * Get all of the accounts for the Aggregator
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
