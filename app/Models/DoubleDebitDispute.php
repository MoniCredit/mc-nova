<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoubleDebitDispute extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'double_debit_disputes';
    protected $casts = [
        'settlement_ids' => 'array',
    ];
}
