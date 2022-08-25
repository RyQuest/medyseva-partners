<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentUser extends Model
{
    use HasFactory;

      
    protected $table = "payment_user";
    protected $guarded = ['id'];
    
    public $timestamps = false;
    
}
