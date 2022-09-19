<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chamber;
class ChamberType extends Model
{
    use HasFactory;

    protected $table = "chamber";
    protected $guarded = ['id'];

    public function chambers(){
        return $this->hasMany(Chamber::class, 'type', 'id');
    }

}
