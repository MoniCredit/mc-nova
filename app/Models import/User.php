<?php
namespace App\Models;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
 
// Audit Log
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Gate;
use OwenIt\Auditing\Contracts\Auditable;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPermissions;
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    public $incrementing = false;
    static $status = [
        "inactive"  => "INACTIVE",
        "pending"  => "PENDING",
        "active"  => "ACTIVE",

    ];
    

    // protected $appends = [
    //     'permission'
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'device_token',
        'google2fa_secret',
        'phone_token',
        'phone_token_expiration_time',
        'phone_verified_at',
        'provider_id',
        'twofa_auth',
        'twofa_code',
        'twofa_expires_at',
        // 'twofa_type',
        'user_codes',
        'usertype',
        'verification_staus',
        'verification_token',
        'email_token',
        'email_verified_at',
        'bvn_details',
        'qr_code',
        'api_token',
        'exchanges',
        'referral_id',
        'robot_settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function boot()
    {
        parent::boot();
        // static::creating(function ($user) {
        //     $user->id = uniqid('US');
        // });
    }

    public function roles(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        )
        ->where('model_has_roles.account_id', Auth::user()->active_account)
        ;
    }
    public function allRoles(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            'role_id'
        )->with('permissions');
    }
    public function allPermissions()
    {
        return $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            'permission_id'
        );
    }

    public function account()
    {
        return $this->hasMany(Account::class, 'user_id');
    }

    public function getPermissionAttribute()
    {
        return $this->getAllPermissions();
    }

    /**
     * Get the current merchant that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentMerchant(): BelongsTo
    {
        if (auth()->check()) {
            $token = request()->bearerToken();
            if (!blank($token)) {
                $decoded = JWTAuth::setToken($token)->getPayload();
                $activeMerchant = $decoded->get('active_merchant');
                if (!blank($activeMerchant)) {
                    return $this->belongsTo(Merchant::class, 'active_merchant', 'id')->where('id', $activeMerchant);
                }
            }
        }
        return $this->belongsTo(Merchant::class, 'active_merchant', 'id');
    }

    /**
     * Get the current account that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currentAccountObject()
    {
        if (auth()->check()) {
            $token = request()->bearerToken();
            if (!blank($token)) {
                $decoded = JWTAuth::setToken($token)->getPayload();
                $activeAccount = $decoded->get('active_account');
                if (!blank($activeAccount)) {
                    if(Gate::allows('admin.manage-all')){
                        return Account::find($activeAccount);
                    } else {
                        $getTeam = Team::where('account_id', $activeAccount)->where('user_id', Auth::id())->first();
                        if ($getTeam) {
                            return Account::find($activeAccount);
                        }
                        return Account::where('user_id', auth()->id())->where('id', $activeAccount)->first();
                    }
                }
            }
        } elseif (request()->public_key) {
            $merchant = Merchant::where('public_key', request()->public_key)->first();
            if(empty($merchant)){
                return [];
            }
            $account = Account::where('id',$merchant->account_id)->first();
            return $account;
        }
        return Account::find(auth()->user()->active_account);
    }

    public function currentAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'active_account', 'id');
    }

    public function routeNotificationForTelegram()
    {
        return 371870726;
    }

    public function getProfileImgAttribute($value)
    {
        return (is_null($value) || $value == '' || $value == 'null' || $value == null) ? $value : env("FILE_URL").($value);    
    }
    
    public function getSelfieIdAttribute($value)
    {
        return (is_null($value) || $value == '' || $value == 'null' || $value == null) ? $value : env("FILE_URL").($value);    
    }
    
    public function getIdentityCardAttribute($value)
    {
        return (is_null($value) || $value == '' || $value == 'null' || $value == null) ? $value : env("FILE_URL").($value);    
    }
    public function getBvnAttribute($value)
    {
        return (is_null($value) || $value == '' || $value == 'null' || $value == null) ? false : true;
    }

    public function liveness()
    {
        return $this->hasOne(Liveness::class)->where('status', 'APPROVED');
    }

    public function getDobAttribute($value)
    {
        // Check if dob is not null and not in the "Y-m-d" format
        if (!is_null($value) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            // Parse the dob using Carbon and format it to "Y-m-d"
            return Carbon::parse($value)->format('Y-m-d');
        }

        return $value;
    }
}
