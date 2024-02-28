<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
// Audit Log
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;
    protected $guarded = [];


    public function customerWallet()
    {
        return $this->hasMany(CustomerWallet::class);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Get all of the transactions for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function approvedTransactions()
    {
        return $this->hasMany(Transaction::class)->where('status', 'APPROVED');
    }

    public function aggregator(): BelongsToMany
    {
        return $this->belongsToMany(Aggregator::class, 'aggregator_customers', 'customer_id', 'aggregator_id');
    }

    /**
     * Get all of the aggregatorCustomer for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aggregatorCustomers(): HasMany
    {
        return $this->hasMany(AggregatorCustomer::class);
    }

    
}
