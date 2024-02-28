<?php

namespace App\Models;

use App\Models\ProvidersCredential;
use Illuminate\Database\Eloquent\Model;
// Audit Log
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Providers extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;
    static $settlementTimeFrame = 1440;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name'];


    /**
     * Get the user associated with the Providers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function credential(): HasOne
    {
        return $this->hasOne(ProvidersCredential::class, 'provider_id');
    }
}
