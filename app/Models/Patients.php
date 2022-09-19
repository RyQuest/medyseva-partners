<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
class Patients extends Model
{
    use HasFactory;
     
    
    protected $table = "patientses";
    protected $guarded = ['id'];
    
    public $timestamps = false;

    public function appointment(){
        return $this->belongsTo(Appointment::class, 'patient_id', 'id');
    }
}
