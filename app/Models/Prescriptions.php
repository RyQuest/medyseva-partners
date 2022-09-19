<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescriptions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
    ];

    /**
     * Get the user which belongs to this prescription .
    */
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function chamber(){
        return $this->belongsTo(Chamber::class, 'chamber_id', 'uid');
    }

    public function patient(){
        return $this->belongsTo(Patients::class, 'patient_id', 'id');
    }

    public function items(){
        return $this->hasMany(PrescriptionsItems::class, 'prescription_id', 'id')->with('drugs');
    }

    
}
