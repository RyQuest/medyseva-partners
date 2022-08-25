<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerInvoice extends Model
{
    use HasFactory;
    
    protected $table = "partner_invoices";
    protected $guarded = ['id'];
    
}
