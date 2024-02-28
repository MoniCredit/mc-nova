<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biller extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'bills_biller';
    protected $hidden = [
        'created_at',
        'updated_at',
        'status',
        'id'
    ];

    public function category()
    {
        return $this->belongsTo(BillCategory::class, 'category_code', 'code');
    }

    public function products()
    {
        return $this->hasMany(BillProduct::class, 'biller_code', 'code');
    }
}
