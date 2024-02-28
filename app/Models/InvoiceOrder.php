<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InvoiceOrder extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $incrementing = false;

    /**
     * Get all of the invoiceOrderItems for the InvoiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceOrderItems()
    {
        return $this->hasMany(InvoiceOrderItem::class)->with(['invoiceItem' => function ($q) {
            $q->select('id', 'name', 'description');
        }]);
    }

    /**
     * Get the user that owns the InvoiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that owns the InvoiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    /**
     * Get the customer that owns the InvoiceOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
