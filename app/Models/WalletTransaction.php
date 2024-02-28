<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;
    // use \OwenIt\Auditing\Auditable;
    use Notifiable;

    protected $table = 'wallet_transactions';
    protected $guarded = [];

    public $appends = ['sessionid', 'bank_status'];
    static $status = [
        "approved"  => "APPROVED",
        "pending"  => "PENDING",
        "holding"  => "HOLDING",
        "declined"  => "DECLINED",

    ];
    static $type = [
        "debit"  => "DEBIT",
        "credit"  => "CREDIT",

    ];
    static $purpose =
    [
        'funding' => 'FUNDING',
        'settlement' => 'SETTLEMENT',
        'bills' => 'BILLS',
        'withdrawal' => 'WITHDRAWAL',
        'internal_transfer' => 'INTERNAL_TRANSFER',
        'external_transfer' => 'EXTERNAL_TRANSFER',
        'reversal' => 'REVERSAL'
    ];
    static $transfer_type = [
        "default"  => "DEFAULT",
        "schedule"  => "SCHEDULE",
        "request"  => "REQUEST",
        "bulk_payment"  => "BULK_PAYMENT",
    ];

    // protected $casts = [
    //     'created_at' => 'datetime:Y-m-d H:i:s',
    //     'updated_at' => 'datetime:Y-m-d H:i:s',
    // ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

    /**
     * Get the wallet that owns the WalletTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function scopeType($query, $value = "CREDIT")
    {
        return $query->where('type', $value);
    }

    public function scopeStatus($query, $value = "APPROVED")
    {
        return $query->where('status', $value);
    }

    protected function getWithdrawalDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function routeNotificationForTelegram()
    {
        return -1001356429052;
    }

    /**
     * Get the transactionDetails associated with the WalletTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transactionDetails(): HasOne
    {
        return $this->hasOne(ProviderTransaction::class, 'payment_reference', 'order_id');
    }

    public function billsTransaction(): HasOne
    {
        return $this->hasOne(BillsTransaction::class, 'wallet_transaction_id', 'wallet_transaction_id');
    }

    public function crVirtualInfo(): BelongsTo
    {
        return $this->belongsTo(VirtualAccount::class, 'craccount_no', 'account_number');
    }

    public function user()
    {
        return $this->crVirtualInfo();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getSessionidAttribute()
    {
        $sessionid = null;
        if ($this->purpose == 'EXTERNAL_TRANSFER' || $this->purpose == 'WITHDRAWAL') {
            if (!$this->schedule_time) {
                if ($this->bank_response && !is_int($this->bank_response)) {
                    if (isset(json_decode($this->bank_response)->responseBody->decryted_response)) {
                        $wemaResponse = json_decode($this->bank_response)->responseBody->decryted_response;
                        $wemaResponse = is_string($wemaResponse) ? $wemaResponse : $wemaResponse->Response;
                        $sessionid = $wemaResponse;
                    }
                }
            }
        }

        return $sessionid;
    }
    public function getBankStatusAttribute()
    {
        $status = $this->status;
        if ($this->purpose == 'EXTERNAL_TRANSFER' || $this->purpose == 'WITHDRAWAL') {
            if (!$this->schedule_time) {
                if ($this->verify_transfer) {
                    $status = 'APPROVED';
                } elseif ($this->bank_response) {
                    if (isset(json_decode($this->bank_response)->responseBody->decryted_response)) {
                        $wemaResponse = json_decode($this->bank_response)->responseBody->decryted_response;
                        $wemaResponse = is_string($wemaResponse) ? $wemaResponse : $wemaResponse->Response;
                        $statusCode = substr($wemaResponse, 0, 2);
                        if ($statusCode == 'XX') {
                            $status = 'PENDING WITH BANK';
                        } elseif ($statusCode == '00') {
                            $status = 'APPROVED';
                        } else {
                            $status = 'PENDING';
                        }
                    } else {
                        if (is_int($this->bank_response)) {
                            $status = 'APPROVED';
                        } else {
                            $status = 'FAILED';
                        }
                    }
                } else {
    
                    $status = 'FAILED';
                }
            }
        }
        return $status;
    }
}
