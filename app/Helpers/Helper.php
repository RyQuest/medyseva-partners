<?php

use App\Models\Chamber;
use Illuminate\Support\Facades\DB;

$vle_comission = 20;
$partner_comission = 10;




function sendNotification($mypost)
    {
        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $firebaseToken = $mypost['firebaseToken'];
            
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $mypost['title'],
                "body" => $mypost['body'],  
            ],
            "data" => isset($mypost['data']) ? $mypost['data'] : null,
        ];
		
        $dataString = json_encode($data);
 // return $dataString;     
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
        return $response;
        // return back()->with('success', 'Notification send successfully.');
    }


function vle_comission($amount){
    $comm = ($amount * $vle_comission) / 100;
    return $comm;
}

function partner_comission($amount){
    $comm = ($amount * $partner_comission) / 100;
    return $comm;
}

function walletAmount($wallet_id){
    $wallet = \App\Models\UserWallet::where('id',$wallet_id)->first();
    if($wallet){
        return $wallet->amount;
    }
    return "0";
}

function userAalletAmount($user_id,$user_role){
    $wallet = \App\Models\UserWallet::where('user_id',$user_id)->where('user_role',$user_role)->first();
    if(null == $wallet){
        return 0;
    }
    return $wallet->amount;
}
function vleUser($id){
    $user = \App\Models\VleUser::where('id',$id)->first();
    return $user;
}

function patientInfo($id){
    $user = \App\Models\Patients::where('id',$id)->first();
    return $user;
}

function getUsername($wallet_id){
    $wallet = \App\Models\UserWallet::where('id',$wallet_id)->first();
    if($wallet){
        if($wallet->user_role == "vle"){
            $data = vleUser($wallet->user_id);
            return $data->name;
        } else{
            $data = getuser($wallet->user_id);
            return $data->name;
        }
    }
}
function getuser($id){
    $user = \App\Models\User::where('id',$id)->first();
    return $user;
}

function patientData($id){
    $user = \App\Models\Patients::where('id',$id)->first();
    return $user;
}

function addressProof($value){
    $data = "";
    if($value == "electricity-bill"){
        $data = "Electricity Bill";
    } else if($value == "water-bill"){
        $data = "Water Bill";
    } else if($value == "telephone-bill"){
        $data = "Telephone Bill";
    }
    return $data;
}

function loginUserWallet(){
     $wallet = \App\Models\UserWallet::where('user_id',auth()->user()->id)->where('user_role','partner')->first();
     return $wallet;
}

function trxInfo($vle_id,$trx_id,$category){
    return \App\Models\TrHistory::where('trx_id',$trx_id)->where('category',$category)->where('vle_id',$vle_id)->first();
}

function apiUrl(){
    return "https://clinic.medyseva.com/";
}


if(!function_exists('amount_to_doctor')){
    function amount_to_doctor($appointment_id, $doctor_id, $amount){

        $doctorTds = ($amount * 10) / 100;

        $old_trx = DB::table('trx_history')->where('appointment_id', $appointment_id)->where('category', 'appointment')->first();

        // admin wallet
        $adminWallet = DB::table('user_wallet')->where('id', 4)->first();
        $adminNewAmount = $adminWallet->amount;
        $adminNewAmount = $adminNewAmount - $amount;


        // doctor wallet
        $docWallet = DB::table('user_wallet')->where('user_id', $doctor_id)->where('user_role', 'user')->first();
        $docNewAmount = $docWallet->amount;

        $docNewAmount = $docNewAmount + $amount;

        if (isset($old_trx)) {
            $data1 = array(
                'user_id' => $doctor_id,
                'trx_id' => $old_trx->trx_id,
                'user_role' => 'user',
                'wallet_id' => $docWallet->id,
                'from_wallet' => 4,
                'to_wallet' => $docWallet->id,
                'category' => 'appointment_referral',
                'appointment_id' => $appointment_id,
                'amount' => $amount,
                'doctor_fee' => 0,
                'junior_doctor_fee' => 0,
                'vle_referral' => 0,
                'partner_referral' => 0,
                'medyseva_referral' => 0,
                'created_at' => my_date_now(),
                'updated_at' => my_date_now(),
                'current_amount' => $adminNewAmount,
                'receiver_amount' => $docNewAmount,
                'patient_id' => $old_trx->patient_id
            );

            // $ids = $ci->admin_model->insert($data1, 'trx_history');
            $ids = DB::table('trx_history')->insert($data1);

            // doctor tds

            $adminNewAmount = $adminNewAmount + $doctorTds;
            $docNewAmount = $docNewAmount - $doctorTds;

            $data1 = array(
                'user_id' => 1,
                'trx_id' => $old_trx->trx_id,
                'user_role' => 'admin',
                'wallet_id' => 4,
                'from_wallet' => $docWallet->id,
                'to_wallet' => 4,
                'category' => 'tds',
                'appointment_id' => $appointment_id,
                'amount' => $doctorTds,
                'doctor_fee' => 0,
                'junior_doctor_fee' => 0,
                'vle_referral' => 0,
                'partner_referral' => 0,
                'medyseva_referral' => 0,
                'created_at' => my_date_now(),
                'updated_at' => my_date_now(),
                'current_amount' => $docNewAmount,
                'receiver_amount' => $adminNewAmount,
                'patient_id' => $old_trx->patient_id
            );

            $ids = DB::table('trx_history')->insert($data1);

            // update doctor wallet
            DB::table('user_wallet')->where('id', $docWallet->id)->update($action);
            
            // update admin wallet
            $action = array('amount' => $adminNewAmount);
            DB::table('user_wallet')->where('id', 4)->update($action);
        }        
    }
}

// current date time function

if (!function_exists('my_date_now')) {

    function my_date_now()
    {

        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));

        $date_time = $dt->format('Y-m-d H:i:s');

        return $date_time;
    }
}


function sendSMS(){
    $apiKey = urlencode('NjM2MzYxNjc3MTZiNmY0MTU4NmQ0YTYzMzE1NDQxNmM=');
	
	// Message details
	$numbers = array(918792579321);
	$sender = urlencode('TXTLCL');
	$message = rawurlencode('Hi,You have got coupon code for 60% discount on appointmwent booking');
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	echo $response;
}

 function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
            
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
    
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
      
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
    
        return back()->with('success', 'Notification send successfully.');
    }

function sendMessage($mobile)
    {
    $apiKey = urlencode('NjM2MzYxNjc3MTZiNmY0MTU4NmQ0YTYzMzE1NDQxNmM=');
	
    // Message details
    $mobile = '91'.$mobile;
	$numbers = array($mobile);
	$sender = urlencode('MEDYSE');
	$message = rawurlencode('Dear Doctor, There is a new patient waiting for you-Medyseva');
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	// Process your response here
	echo $response;
    }

    function setPassword($email,$password){
	    $data = array('email' =>$email, 'password' => $password);
	    $ch = curl_init('https://clinic.medyseva.com/api/reset_paasword_byMail');
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    curl_close($ch);
	    echo $response;
    }

    if(!function_exists('session_time_period')){
        function session_time_period($session)
        {
            $total_timestamp = 0;
            $created_at = $session->created_at;
            $session_res = \App\Models\VleLoginCount::where('user_id',$session->user_id)->whereBetween('created_at', [$created_at.' 00:00:01', $created_at.' 23:59:59'])->get();
            if(!empty($session_res)){
                foreach($session_res as $value){
                    if($value->time != null || $value->time > 0){
                        $diff_time = $value->time;
                        // $diff_time = strtotime($value->logout_datetime) - strtotime($value->login_datetime);
                    }else{
                        $rand_minute = rand(10,99);
                        $logout_timestamp = strtotime("+".$rand_minute." minutes", strtotime($value->login_datetime));
                        $logout_datetime = date('Y-m-d H:i:s', $logout_timestamp);
                        $diff_time = $logout_timestamp - strtotime($value->login_datetime);
                        DB::table('session_count')->where('id', $value->id)->update(['time'=>$diff_time, 'logout_datetime'=>$logout_datetime]);
                    }
                    $total_timestamp = $total_timestamp + intval($diff_time);
                }
            }

            $h = $total_timestamp / 3600 % 24;
            $m = $total_timestamp / 60 % 60; 
            $s = $total_timestamp % 60;
            $time_str = $h.' Hour,'.$m." Min,".$s." Sec";
            return $time_str;
        }
    }


    if(!function_exists('total_appoinment_report')){
        function total_appoinment_report($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('date', $created_at)
                                    ->count();
            return $total_appointments;
        }
    }

    if(!function_exists('total_gen_appoinment_report')){
        function total_gen_appoinment_report($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('appointment_type', 1)
                                    ->where('date', $created_at)
                                    ->count();
            return $total_appointments;
        }
    }

    if(!function_exists('total_spe_appoinment_report')){
        function total_spe_appoinment_report($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('appointment_type', 2)
                                    ->where('date', $created_at)
                                    ->count();
            return $total_appointments;
        }
    }

    if(!function_exists('total_vle_commission_report')){
        function total_vle_commission_report($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->join('trx_history', 'appointments.id', '=', 'trx_history.appointment_id')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('trx_history.category', 'appointment_referral')
                                    ->where('trx_history.user_role', 'vle')
                                    ->where('date', $created_at)
                                    // ->groupBy('appointments.added_by', 'appointments.date')
                                    ->sum('trx_history.amount');
            return $total_appointments;
        }
    }

    if(!function_exists('total_vle_commission_back')){
        function total_vle_commission_back($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->join('trx_history', 'appointments.id', '=', 'trx_history.appointment_id')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('trx_history.category', 'appointment_referral')
                                    ->where('trx_history.user_role', 'vle')
                                    ->where('date', $created_at)
                                    // ->groupBy('appointments.added_by', 'appointments.date')
                                    ->sum('trx_history.amount');
            return $total_appointments;
        }
    }

    if(!function_exists('total_partner_commission_report')){
        function total_partner_commission_report($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->join('trx_history', 'appointments.id', '=', 'trx_history.appointment_id')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('trx_history.category', 'appointment_referral')
                                    ->where('trx_history.user_role', 'partner')
                                    ->where('date', $created_at)
                                    // ->groupBy('appointments.added_by', 'appointments.date')
                                    ->sum('trx_history.amount');
            return $total_appointments;
        }
    }

    if(!function_exists('total_partner_commission_back')){
        function total_partner_commission_back($session)
        {
            $total_appoinment = 0;
            $created_at = $session->sees_created_at;
            
            $total_appointments = DB::table('appointments')
                                    ->join('trx_history', 'appointments.id', '=', 'trx_history.appointment_id')
                                    ->where('added_by', $session->user_id)
                                    ->where('added_by_role', 'vle')
                                    ->where('trx_history.category', 'appointment_referral')
                                    ->where('trx_history.user_role', 'partner')
                                    ->where('date', $created_at)
                                    // ->groupBy('appointments.added_by', 'appointments.date')
                                    ->sum('trx_history.amount');
            return $total_appointments;
        }
    }
?>