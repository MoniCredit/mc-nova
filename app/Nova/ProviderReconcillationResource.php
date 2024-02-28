<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Models\ProviderTransaction;
use Laravel\Nova\Http\Requests\NovaRequest;

class ProviderReconcillationResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProviderReconcillationResource>
     */
    public static $model = \App\Models\ProviderReconcillationResource::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        $data = [];
        $tenants = tenant()->all();
        foreach($tenants as $tenant) {
            tenancy()->initialize($tenant->id);
            $providerTransactionCredit = ProviderTransaction::where([
                'transaction_type' => 'CREDIT',
                'provider_id' => $request->provider_id,
                'status' => 'APPROVED'
            ]);
            $providerTransactionDebit = ProviderTransaction::where([
                'transaction_type' => 'DEBIT',
                'provider_id' => $request->provider_id,
                'status' => 'APPROVED'
            ]);
            if ($request->provider_id == 'wema' || $request->provider_id == 'creditpay') {
                $providerTransactionCredit = ProviderTransaction::where([
                    'transaction_type' => 'CREDIT',
                    'status' => 'APPROVED'
                ])->where('provider_id', 'wema')->orWhere('provider_id', 'creditpay');
                $providerTransactionDebit = ProviderTransaction::where([
                    'transaction_type' => 'DEBIT',
                    'status' => 'APPROVED'
                ])->where('provider_id', 'wema')->orWhere('provider_id', 'creditpay');
            }
            $tenantData = (object)[
                'tenant' => $tenant->id,
                'provider' => $request->provider_id,
                'total_credit' => $providerTransactionCredit->sum('amount_paid'),
                'total_debit' => $providerTransactionDebit->sum('amount_paid'),
                // 'wallet_transaction' => $walletTransaction->sum('amount')
            ];
            array_push($data, $tenantData);
            tenancy()->end();
        }
        return $data;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
