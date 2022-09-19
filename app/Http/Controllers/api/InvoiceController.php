<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceItem;
use App\Models\Invoices;
use App\Models\VleUser;
use App\Models\Prescriptions;

class InvoiceController extends Controller
{
    
    public function vle_invoice(Request $request){
        // $user = \JWTAuth::parseToken()->authenticate($request->token);
        $user_id = $request->input('user_id');
        $limit = $request->input('limit');
        $offset = $request->input('offset');
        $search_query = $request->input('search_query');

        $invoice = Invoices::with('patient')
        ->where('created_by',$user_id)
        ->where(function ($query) use($search_query){
            if($search_query != '' && !empty($search_query) ){
                $query->where('invoice_number', 'LIKE', '%'.$search_query.'%');
            }
        })
        ->whereOr('vle_id',$user_id)
        ->take($limit)
        ->skip($offset)
        //->groupBy('invoices.invoice_id')
        ->get();

        foreach ($invoice as $key => $value) {
            $invoice[$key]['prescription'] = \DB::table('prescription')->where('appointment_id',$value->appointment_id)->get();
        }
        return response(['status' => 1,'data' => $invoice]);
    }




}
