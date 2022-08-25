<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VleUser;
use App\Models\Patients;

class VleController extends Controller
{
  
  
    public function login(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            //   return response()->json(['error'=>$validator->errors()], 401); 
            return response(['status' => 0, 'msg' => $validator->errors()->first()]);
        }
        

        $user = VleUser::where('email', $request->email)->first();

        if(auth()->guard('vle')->attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = auth()->guard('vle')->user();

            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 

           
   
            return response()->json([

                 'status'=>1,
                 'token'=>$success,
                 'user'=>$user

            ]);
        } 
        else{ 
            return response()->json([
                'status' => 0,
                'error' => "Authentication fails",
            ]);
        } 


       
    }


   public function vlePatient(Request $request){
     
        $patients=Patients::where('added_by',$request->user_id)->get();

        return response()->json([
            'status' => 1,
            'patient' => $patients,
        ]);
        
   }

}
