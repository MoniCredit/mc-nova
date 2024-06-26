<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class WebhookTransactionTracking extends Model
{
    use HasFactory;
//    protected $connection = 'socialpay';
    use CentralConnection;

    protected $guarded = [];
}
