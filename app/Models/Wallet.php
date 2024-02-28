<?php

namespace App\Models;

use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use function PHPUnit\Framework\isNull;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Wallet extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes, Sortable;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    public $incrementing = false;

    static $status = [
        "deactivated"  => "DEACTIVATED",
        "approved"  => "APPROVED",
        "pending"  => "PENDING",
        "declined"  => "DECLINED",
    ];

    CONST WALLET_RECONCILIATION_FILENAME='failed_reconciliation.json';
    static $walletPromptActions = [
        'fix_wallet_reconciliation'=>'Fix wallet transaction',
        'reconcile_recent_wallet_transaction'=>'Reconcile recent wallet transaction',
        'reconcile_all_wallet_transaction'=>'Reconcile all wallet transaction'
    ];
    
    static $type = [
        "credit"  => "CREDIT",
        "debit"  => "DEBIT",

    ];
    static $reconciledStatus = [
        "reconciled"  => "RECONCILED",
        "unreconciled"  => "UNRECONCILED",

    ];
    static $failedReconciledType = [
        "unequal_balance"  => "UNEQUAL_BALANCE",
        "unequal_transaction_balance"  => "UNEQUAL_TRANSACTION_BALANCE",

    ];
    static $walletType = [
        "personal"  => "PERSONAL",
        "customer"  => "CUSTOMER",
        "merchant"  => "MERCHANT",
        "contract"  => "CONTRACT",
        "settlementbank"  => "SETTLEMENTBANK",
    ];

    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];
    protected $sortable = [
        'balance'
    ];
    

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }
    
    /**
     * The customers that belong to the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    /**
     * The merchants that belong to the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function merchants()
    {
        return $this->belongsToMany(Merchant::class);
    }

    /**
     * The users that belong to the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function personals()
    {
        return $this->belongsToMany(User::class);
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }

    /**
     * Get all of the virtualAccounts for the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function virtualAccounts()
    {
        return $this->hasMany(VirtualAccount::class);
    }
    public function virtualAccount()
    {
        return $this->belongsTo(VirtualAccount::class, 'virtual_account_id', 'id');
    }

    /**
     * Get the settlement bank that owns the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function settlementBank()
    {
        return $this->belongsTo(SettlementBank::class, 'settlement_bank_id', 'id');
    }
    /**
     * Get the customer associated with the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }


    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function approvedTransactions()
    {
        return $this->hasMany(WalletTransaction::class)->where('status', 'APPROVED');
    }

    public function scopeStatus($query, $value = "APPROVED")
    {
        return $query->where('status', $value);
    }

    public function scopeType($query, $value = "MERCHANT")
    {
        return $query->where('wallet_type', $value);
    }

    /**
     * Get the account that owns the Wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function getBalanceAttribute($value)
    {
        return ($value == null || $value == '') ? 0 : $value;
    }

    public function billTransactions()
    {
        return $this->hasMany(BillsTransaction::class, 'wallet_id', 'id');
    }

    public function aggregatorCustomer()
    {
        return $this->hasMany(AggregatorCustomer::class);
    }
}
