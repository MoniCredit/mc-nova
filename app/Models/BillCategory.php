<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bills_category';
    protected $hidden = [
        'created_at',
        'updated_at',
        'status',
        'id'
    ];

    public function billers()
    {
        return $this->hasMany(Biller::class, 'category_code', 'code');
    }
}
