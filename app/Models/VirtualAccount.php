<?php

namespace App\Models;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
// Audit Log
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Http;

class VirtualAccount extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';

    public $incrementing = false;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('Africa/Lagos')->format('Y-m-d H:i:s');
    }

    protected $guarded = [];

    /**
     * Get the wallet that owns the VirtualAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($virtualAccount) {
            try {
                $tenantId = tenant("id");
                
                $createCentralVirtualAccount = CentralVirtualAccount::create([
                    "id" => uniqid('VA'),
                    'name' => $virtualAccount->name,
                    'first_name' =>$virtualAccount->first_name,
                    'last_name' => $virtualAccount->last_name,
                    'account_name' => $virtualAccount->account_name,
                    'account_number' => $virtualAccount->account_number,
                    'bank_name' => $virtualAccount->bank_name,
                    'account_type' => $virtualAccount->account_type,
                    'service_provider' => $virtualAccount->service_provider,
                    'email' => $virtualAccount->email,
                    'phone' =>$virtualAccount->phone,
                    'expiry_date' => $virtualAccount->expiry_date,
                    'wallet_id' => $virtualAccount->wallet_id,
                    "tenant_id" => $tenantId
                ]);
    
                if(!$createCentralVirtualAccount) {

                    $json = "Unable to create central virtual account";
                    $error = $json["message"];
                    $vAccount = json_encode($virtualAccount, JSON_PRETTY_PRINT);
    
                    $message = "The following error occured while trying  to create central virtual account on tenant $tenantId \n
                    $error \n   
                    Virtual account 
                    \n $vAccount
                    ";
                    Helper::reportToChannels($message);
                }
                
            } catch (\Throwable $th) {
                $vAccount = json_encode($virtualAccount, JSON_PRETTY_PRINT);
                $err = $th->getMessage();
    
                $message = "The following error occured while trying  to create central virtual account on tenant $tenantId \n
                Virtual account 
                \n $err
                ";
                Helper::reportToChannels($message);
                
            }
            
        });
    }

}
