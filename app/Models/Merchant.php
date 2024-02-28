<?php

namespace App\Models;

use Auth;
use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $hidden = [
        'token',
        'remember_token',
    ];
    protected $guarded = [];
    static $status = [
        'inactive' => "INACTIVE",
        'pending' => "PENDING",
        'activated' => "ACTIVATED",
        'deactivated' => "DEACTIVATED",
    ];
    static $type = [
        'merchant' => "MERCHANT",
        'personal' => "PERSONAL",
    ];
    protected $casts = ['merchant_data' => 'array', ] ;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function settlementBanks()
    {
        return $this->hasMany(SettlementBank::class);
    }
    public function settlementBank()
    {
        return $this->belongsTo(SettlementBank::class, 'id', 'merchant_id');
    }

    public function commercials()
    {
        return $this->hasOne(Commercial::class, 'id', 'commercial_id');
    }

    public function providersCredentials()
    {
        return $this->hasOne(ProvidersCredential::class, 'id', 'provider_credential_id');
    }

    public function team()
    {
        return $this->hasMany(Team::class, 'merchant_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'merchant_id', 'id');
    }

    public function paymentLinks()
    {
        return $this->hasMany(PaymentLink::class, 'merchant_id', 'id');
    }

    public static function getMerchantId()
    {
        if (session('merchant_id')) {
            return (session('merchant_id'));
        }
        return auth("api")->user()->active_merchant;
    }

    /**
     * Get the account that owns the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function getBusinessLogoAttribute($value)
    {   
        return (is_null($value) || $value == '' || $value == 'null' || $value == null) ? $value : env("FILE_URL").($value);
    }
}
