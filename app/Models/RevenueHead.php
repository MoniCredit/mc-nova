<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RevenueHead extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    protected $guarded = [];
    protected $table = 'revenue_heads';

    public function settlementBank()
    {
        return $this->belongsTo('App\Models\SettlementBank');
    }
}
