<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrHistory extends Model
{
    use HasFactory;

    protected $table = "trx_history";
    protected $guarded = ['id'];
    
}
