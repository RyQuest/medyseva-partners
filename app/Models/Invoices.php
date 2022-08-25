<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $table = "invoices";
    protected $guarded = ['id'];

    public function patient(){
        return $this->belongsTo(\App\Models\Patients::class,'patient_id');
    }
    
    public function vle_comission($amount){
         $comm = ($amount * 19) / 100;
        return $comm;
    }
    public function partner_comission($amount){
         $comm = ($amount * 9.50) / 100;
        return $comm;
    }

    
}
