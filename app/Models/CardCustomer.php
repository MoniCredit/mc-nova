<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardCustomer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $guarded = [];
    protected $table = 'card_customers';

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getResponseDataAttribute($value)
    {
        return json_decode($value, true); // Use true to get an associative array
    }

    public function getResponseDataBridgeAttribute($value)
    {
        return json_decode($value, true); // Use true to get an associative array
    }
}
