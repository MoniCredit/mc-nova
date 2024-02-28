<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Commercial extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public const FIELD = [
        'name' => 'name',
        'type' => 'type',
        'cap' => 'cap',
        'transfer_cap' => 'transfer_cap',
        'card_cap' => 'card_cap',
        'leftover' => 'leftover',
        'minimum' => 'minimum',
    ];

    public const STATUS = [
        1 => 'active',
        0 => 'inactive',
    ];

    protected $guarded = [];

    /**
     * Get all of the comments for the Commercial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings(): HasMany
    {
        return $this->hasMany(CommercialSetting::class)->where('charge_type', 'COLLECTION');
    }
}
