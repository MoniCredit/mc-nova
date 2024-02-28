<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class CentralVirtualAccount extends Model 
{
    use HasFactory;
    use CentralConnection;


    protected $keyType = 'string';

    public $incrementing = false;
    protected $table = 'central_virtual_accounts';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    protected $guarded = [];
    
    

}
