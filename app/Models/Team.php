<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model implements Auditable
{
    use HasRoles;

    use HasFactory;


    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    //
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public static function getTeam($merchantId)
    {
        return  DB::table('teams')
                    ->join('users', 'users.id', '=', 'teams.user_id')
                    ->where('teams.merchant_id', $merchantId)
                    ->get();
    }
}
