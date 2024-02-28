<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulkTransactionProcessing extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "bulk_transaction_processing";
    public static $status = [
        "pending" => "PENDING",
        "processing" => "PROCESSING",
        "completed" => "COMPLETED",
        "failed"=>"FAILED"
    ];

    public static $nextRetryMinutes = 2;


    public function bulkParent() : BelongsTo {
        return $this->belongsTo(BulkPayment::class, 'batch_id', 'id');
    }
}
