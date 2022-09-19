<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patients;
class Invoices extends Model
{
    use HasFactory;

    protected $table = "invoices";
    protected $guarded = ['id'];

    public function patient(){
        return $this->hasOne(\App\Models\Patients::class,'id', 'patient_id');
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
