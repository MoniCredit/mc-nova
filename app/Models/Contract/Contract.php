<?php

namespace App\Models\Contract;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Get all of the subaccounts for the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subaccounts()
    {
        return $this->hasMany(ContractSubaccount::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
