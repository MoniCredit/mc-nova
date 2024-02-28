<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceHistory extends Model
{
    use HasFactory;

    static $status = [
        "active"  => "ACTIVE",
        "pending"  => "PENDING",
        "inactive"  => "INACTIVE",
    ];
    static $type = [
        "web"  => "WEB",
        "api"  => "API",
        "mobile"  => "MOBILE",
    ];

    protected $casts = [
        'device_info' => 'array'
    ];

    protected $guarded=[];
}
