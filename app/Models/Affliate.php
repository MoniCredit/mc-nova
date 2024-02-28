<?php

namespace App\Models;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Affliate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    public static function getAffliateReferrals($userId)
    {
        $referrals = Merchant::select('id', 'user_id', 'business_name', 'status', 'created_at')
                            ->where('referral', $userId)->count();
        return $referrals;
    }

    public static function getAffliateEarnings($merchant, $type)
    {
        $earningSql = DB::table('transaction_charges as tc')
                        ->select(DB::raw('(SUM(tc.split_amount) + SUM(tc.flat_amount)) as commission'))
                        ->whereIn('wallet_id', $merchant);
        if ($type) {
            $earningSql->where('party_type', $type);
        }
        $earningSql = $earningSql->get()->toArray();
        $earnings = array_sum(array_column($earningSql, 'commission'));

        return $earnings;
    }

    public static function getAffliateWithdrawals($accountId)
    {
        $withdrawals = Settlement::where('type', 'AFFLIATE')
                                ->where('account_id', $accountId)
                                ->where('status', '!=', 'FAILED')
                                ->sum('amount');
        return $withdrawals;
    }
}
