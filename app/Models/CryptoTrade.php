<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CryptoTrade extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'crypto_trades';
    protected $primaryKey = 'trade_id';

    protected $fillable = [
        'trade_id', 'price'
    ];

}
