<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $guarded = [];
    static $account_type = [
        'personal' => 'PERSONAL',
        'merchant' => 'MERCHANT',
    ];
    static $name = [
        'premium_personal' => 'Premium Personal',
        'advance_personal' => 'Advanced Personal',
        'advance_business' => 'Advanced Business',
        'premium_business' => 'Premium Business',
    ];
}
