<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentUpload extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $keyType = 'string';
    public $incrementing = false;
    static $status = [
        "approved"  => "APPROVED",
        "pending"  => "PENDING",
        "declined"  => "DECLINED",

    ];

    // protected $with=["user", "tier"];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class,"user_id", "id");
    }

    public function tier() : BelongsTo {
        return $this->belongsTo(Tier::class,"current_tier_id", "id");
    }
}
