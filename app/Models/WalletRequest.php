<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletRequest extends Model
{
    use HasFactory;

    protected $table = 'wallet_requests';
    protected $guarded = [];
    static $bank_codes = [
        "default" => "001"
    ];

    protected $hidden = [
        'deleted_at',
        'description',
        'bank_id',
        'bank_code',
        'date',
    ];

    public function virtualAccount() : BelongsTo {
        return $this->belongsTo(VirtualAccount::class, 'dbaccount_no', 'account_number');
    }
}
