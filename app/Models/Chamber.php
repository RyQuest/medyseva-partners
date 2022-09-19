<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChamberType;
class Chamber extends Model
{
    use HasFactory;

    protected $table = "chamber";
    protected $guarded = ['id'];

    public function type(){
        return $this->belongsTo(ChamberType::class, 'type', 'id');
    }

}
