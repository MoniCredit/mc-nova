<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkPayment extends Model
{
    use HasFactory;

    public static $status = [
        "pending" => "PENDING",
        "processing" => "PROCESSING",
        "completed" => "COMPLETED",
        "failed"=>"FAILED"
    ];

    protected $guarded=[];
}
