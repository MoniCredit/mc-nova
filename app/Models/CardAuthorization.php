<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardAuthorization extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    public function getResponseDataAttribute($value)
    {
        return json_decode($value, true); // Use true to get an associative array
    }


}
