<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];
    protected $table = 'cards';

    public function card_customer()
    {
        return $this->belongsTo(CardCustomer::class, 'card_customer_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
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
