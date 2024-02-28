<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class Setting extends Model
{
    use HasFactory;
    use CentralConnection;

    protected $guarded = [];
}
