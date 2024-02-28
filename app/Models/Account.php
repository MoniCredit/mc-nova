<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;
    protected $hidden = [
        'transaction_pin',
        'slug',
    ];
    protected $table = 'accounts';
    protected $guarded = [];
    static $status = [
        "inactive"  => "INACTIVE",
        "pending"  => "PENDING",
        "active"  => "ACTIVATED",
        "deactive"  => "DEACTIVATED",

    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function aggregator()
    {
        return $this->belongsTo(Aggregator::class);
    }

    /**
     * Get the merchant associated with the Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function merchant(): HasOne
    {
        return $this->hasOne(Merchant::class);
    }

    public function tiers()
    {
        return $this->belongsTo(Tier::class, 'tier', 'id');
    }
}
