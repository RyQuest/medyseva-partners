<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VleLoginCount extends Model
{
    use HasFactory;

    protected $table ="session_count";
    protected $guarded = ["id"];


    


}
