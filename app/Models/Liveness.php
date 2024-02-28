<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liveness extends Model
{
    use HasFactory;

    static $status = [
        "processing"  => "PROCESSING",
        "approved"  => "APPROVED",
        "pending"  => "PENDING",
        "declined"  => "DECLINED",
        "failed"  => "FAILED",
    ];

    protected $guarded=[];

    static $providers = [
        "dojah"  => "DOJAH",
    ];

    static $webhookStatus = [
        "failed"  => "FAILED",
        "completed"  => "COMPLETED",
    ];

    protected $casts =[
        "verification_results"=>'array',
        "uploaded_images"=>'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
