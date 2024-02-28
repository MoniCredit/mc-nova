<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded=[];

    static $type = [
        "notify" => "notify",
        "popup" => "popup",
    ];
    static $status = [
        "active" => "ACTIVE",
        "inactive" => "INACTIVE",
    ];

    protected $keyType = 'string';
    public $incrementing = false;



}
