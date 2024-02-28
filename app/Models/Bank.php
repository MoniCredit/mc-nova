<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Bank extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    // protected $hidden = [
    //     // 'id',
    //     'slug',
    // ];

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
