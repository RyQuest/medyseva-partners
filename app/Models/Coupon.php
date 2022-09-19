<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_mobile',
        'coupon_code',
        'coupon_type',
        'amount',
        'amount_type',
        'limited_time',
        'description',
        'state',
        'created_by',
        'expiry_date',
        'status',
        'user_type'
    ];
    protected $table = "coupon";
}
