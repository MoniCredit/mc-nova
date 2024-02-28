<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProviderSettlement extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    static $status = [
        "unreconciled" => "UNRECONCILED",
        "reconciled" => "RECONCILED",
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden=["filename","payment_paid"];
}
