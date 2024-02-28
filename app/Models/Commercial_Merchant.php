<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Commercial_Merchant extends Model implements Auditable
{
    //
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'commercial_merchants';
    protected $fillable = [
        'type',
        'merchant_id',
        'commercial_id',
        'status'
    ];
}
