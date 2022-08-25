<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionsItems extends Model
{
    use HasFactory;

    protected $table = "prescription_items";

    public $timestamps = false;


    protected $fillable = [
        'chamber_id',
        'patient_id',
        'appointment_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function chamber(){
        return $this->belongsTo(Chamber::class, 'chamber_id', 'uid');
    }

    public function patient(){
        return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function drugs(){
        return $this->belongsTo(Drugs::class, 'drug_id', 'id');
    }




}
