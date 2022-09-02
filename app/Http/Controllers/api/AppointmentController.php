<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Chamber;
use App\Models\Patients;
use App\Models\Patient;
use App\Models\TrHistory;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\VleUser;
use Carbon\Carbon;
class AppointmentController extends Controller
{
    
    public function create(Request $request)
    {

        // $data=$request->all();

        // print_r($data);
        // exit;
        
        $validator = \Validator::make($request->all(), [
            'consultation_type' => 'required',
            'date' => 'required',
            'patient_type' => 'required',
        ]);


        if ($validator->fails()) {
            return response(['status' => 0, 'msg' => $validator->errors()->first()]);
        }



        if ($request->patient_type == "1") {
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'mobile' => 'required',
                'age' => 'required',
            ]);
            if ($validator->fails()) {
                return response(['status' => 0, 'msg' => $validator->errors()->first()]);
            }
        } else{
            $validator = \Validator::make($request->all(), [
                'patient_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response(['status' => 0, 'msg' => $validator->errors()->first()]);
            }
        }
       // $user = JWTAuth::parseToken()->authenticate($request->get('token'));
       


       $user = VleUser::where('id',$request->user_id)->first();



        $vleUserWallet = UserWallet::where('user_id',$user->id)->where('user_role','vle')->first();
       
       $consultation_fee = 0;
        
       if ($request->consultation_type == "1") {
            $consultation_fee = 150;
        } else {
            $consultation_fee = 500;
        }
        if ($consultation_fee >  $vleUserWallet->amount) {
            return response(['status' => 0, 'msg' => 'Insufficient wallet amount']);
        }

        $patient = null;
        if ($request->patient_type == "1") {
            $patient = Patients::create([
                'user_id' => $user->id,

                'name' => $request->name,

                'email' => $request->email,

                'mr_number' => rand(11111, 99999),

                'about_id' => $request->about_medyseva,
                'other' => $request->other,

                'age' => $request->age,

                'govt_id' => $request->govt_id,

                'govt_id_detail' => $request->govt_id_detail,

                'occuptation' => $request->occuptation,
                'weight' => $request->weight,

                'sex' => $request->sex,

                'mobile' => $request->mobile,

                'present_address' => $request->present_address,

                'password' => bcrypt(rand(1111, 9999)),

                'created_at' => date('Y-m-d H:i:s'),

                'added_by' => $user->id,
                'added_by_role' => 'vle',
                'national_health_id' => $request->national_health_id,
            ]);
        } else {
            $patient = Patients::find($request->patient_id);
        }
        if(null == $patient){
            return response(['status' => 0, 'msg' => 'Patient not found']);
        }
        $chamber = Chamber::find($user->chamber_id);
        
        if(null == $chamber){
            return response(['status' => 0, 'msg' => 'Chamber not found']);
        }
        $appointment = Appointment::create([
            'chamber_id' => $chamber->uid,
            'user_id' => 0,
            'patient_id' => $patient->id,
            'camp_type' => "",
            'camp_name' => '',

            'serial_id' => 0,

            'date' => $request->date,

            'time' => $request->time,

            'status' => 0,

            'type' => $request->cons_type,

            't' => $request->t,

            'p' => $request->p,

            'r' => $request->r,

            'bp' => $request->bp,

            'ht' => $request->ht,

            'wt' => $request->wt,

            'spo2' => $request->spo2,

            'chief_complains' => $request->chief_complains,
            'consultations_type'  => "on_line",//$request->get('payment_mode'),
            'follow_up' => $request->follow_up,
            'created_at' => date('Y-m-d H:i:s'),
            'added_by' => $user->id,
            'added_by_role' => 'vle',
            'fbs' => $request->fbs,
            'rbs' => $request->rbs,
            'ppbs' => $request->ppbs,
            'blood_group' => $request->blood_group,
            'appointment_type' => $request->consultation_type
        ]);

         
        $videourl = 'https://meet.medyseva.com/' . $appointment->id;
		Appointment::where(["id"=>$appointment->id])->update(['video_link' => $videourl]);



        if ($request->consultation_type == "1") {
            $service_fee = 150;
            $vle_ref = 20;
            $partner_ref = 10;
            $medy_sewa_ref = 119;
        } else {
            $service_fee = 500;
            $vle_ref = 60;
            $partner_ref = 30;
            $medy_sewa_ref = 410;
        }

        $vleTds = ($vle_ref * 5) / 100;

        $partnerTds = 0;

        if ($user->added_by_role == "partner") {
            $partnerTds = ($partner_ref * 5) / 100;
            $medy_sewa_ref = $medy_sewa_ref + $partnerTds;
        } else {
            $partner_ref = 0;
        }

        $trx_id = uniqid();

        $medy_sewa_ref = $medy_sewa_ref + $vleTds;

        $loginUserAmt =  $vleUserWallet->amount;
        $loginUserAmt = $loginUserAmt - $service_fee;

        // admin wallet
        $adminwallet = UserWallet::find(4);
        $adminNewAmount = $adminwallet->amount + $service_fee;

        TrHistory::create([
            'user_id' => $user->id,
            'trx_id' => $trx_id,
            'user_role' =>  'vle',
            'wallet_id' =>  $vleUserWallet->id,
            'from_wallet' =>  $vleUserWallet->id,
            'to_wallet' => 4,
            'category' => 'appointment',
            'appointment_id' => $appointment->id,
            'amount' => $service_fee,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'current_amount' => $loginUserAmt,
            'receiver_amount' => $adminNewAmount,
            'patient_id' => $patient->id
        ]);

        // add vle ref
        $adminNewAmount = $adminNewAmount - $vle_ref;

        $loginUserAmt = $loginUserAmt + $vle_ref;

        TrHistory::create([
            'user_id' => $user->id,
            'user_role' =>  'vle',
            'trx_id' => $trx_id,
            'wallet_id' =>  $vleUserWallet->id,
            'from_wallet' => 4,
            'to_wallet' =>  $vleUserWallet->id,
            'category' => 'appointment_referral',
            'appointment_id' => $appointment->id,
            'amount' => $vle_ref,
            'doctor_fee' => 0,
            'junior_doctor_fee' => 0,
            'vle_referral' => $vle_ref,
            'partner_referral' => 0,
            'medyseva_referral' => $medy_sewa_ref,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'current_amount' => $adminNewAmount,
            'receiver_amount' => $loginUserAmt,
            'patient_id' => $patient->id
        ]);

        // add tds
        $adminNewAmount = $adminNewAmount + $vleTds;
        $loginUserAmt = $loginUserAmt - $vleTds;

        TrHistory::create([
            'user_id' => 1,
            'user_role' =>  'admin',
            'trx_id' => $trx_id,
            'wallet_id' => 4,
            'from_wallet' => $vleUserWallet->id,
            'to_wallet' => 4,
            'category' => 'tds',
            'appointment_id' => $appointment->id,
            'amount' => $vleTds,
            'doctor_fee' => 0,
            'junior_doctor_fee' => 0,
            'vle_referral' => $vle_ref,
            'partner_referral' => 0,
            'medyseva_referral' => $medy_sewa_ref,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'current_amount' => $loginUserAmt,
            'receiver_amount' => $adminNewAmount,
            'patient_id' => $patient->id
        ]);

        // partner ref
        if ($partner_ref > 0) {
            $partnerWallet = UserWallet::where('user_id',$user->added_by)->first();
            $partnerUserWallet = $partnerWallet->amount;

            $adminNewAmount = $adminNewAmount - $partner_ref;
            $partnerUserWallet = $partnerUserWallet + $partner_ref;

            TrHistory::create([
                'user_id' => 96,
                'trx_id' => $trx_id,
                'user_role' => 'partner',
                'wallet_id' => $partnerWallet->id,
                'from_wallet' => 4,
                'to_wallet' => $partnerWallet->id,
                'category' => 'appointment_referral',
                'appointment_id' => $appointment->id,
                'amount' => $partner_ref,
                'doctor_fee' => 0,
                'junior_doctor_fee' => 0,
                'vle_referral' => $vle_ref,
                'partner_referral' => 0,
                'medyseva_referral' => $medy_sewa_ref,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'current_amount' => $adminNewAmount,
                'receiver_amount' => $partnerUserWallet,
                'patient_id' => $patient->id
            ]);

            // add tds
            $adminNewAmount = $adminNewAmount + $partnerTds;

            $partnerUserWallet = $partnerUserWallet - $partnerTds;

            TrHistory::create([
                'user_id' => 1,
                'trx_id' => $trx_id,
                'user_role' => 'admin',
                'wallet_id' => 4,
                'from_wallet' => $partnerWallet->id,
                'to_wallet' => 4,
                'category' => 'tds',
                'appointment_id' => $appointment->id,
                'amount' => $partnerTds,
                'doctor_fee' => 0,
                'junior_doctor_fee' => 0,
                'vle_referral' => $vle_ref,
                'partner_referral' => 0,
                'medyseva_referral' => $medy_sewa_ref,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'current_amount' => $partnerUserWallet,
                'receiver_amount' => $adminNewAmount,
                'patient_id' => $patient->id
            ]);

            // update partner wallet
            UserWallet::where('id', $partnerWallet->id)->update(['amount' => $partnerUserWallet]);
        }

        // update user wallet
        UserWallet::where('id', 4)->update(['amount' => $adminNewAmount]);
        UserWallet::where('id',  $vleUserWallet->id)->update(['amount'=> $loginUserAmt]);


             
		if($request->post('consultation_type') == 1){
			$firebaseToken = User::whereNotNull('device_token')
						->where('device_token', '!=', '')
						->where('device_token', '!=', '0')
						->where('doctor_type' , '0')
						->pluck('device_token')
						->all();
			
					$data = [
						'firebaseToken' => $firebaseToken,
						'title' => 'New Appointment has been arrised',
						'body' => 'Hello Doctor! Patient has booked an appointment. To start consulting immediately',
						'data' => [
							'video_url' => $videourl,
							'type' => 1,
							'appointment_id' => $appointment->id,
						],					
					];
			

			$res = sendNotification($data);
		}




        return response(['status' => 1, 'msg' => 'Appointment created successfully']);
    }

    public function index(Request $request)
    {

        $appointment = Appointment::select('appointments.*','patientses.name','patientses.mobile','patientses.email')
        ->where('appointments.added_by',$request->user_id)
        ->join('patientses','patientses.id','=','appointments.patient_id')->orderBy('id','desc')
        ->take($request->limit)
        ->skip($request->offset)
        ->latest()
        ->get();

         

        return response(['status' => 1,'data' => $appointment]);
    }


    public function vleTodayAppointment(Request $request)
    {
         
       /* $appointment = Appointment::select('appointments.*','patientses.name','patientses.mobile','patientses.email','invoices.id as invoice_id')
                       ->where('appointments.added_by',$request->user_id)
                       ->whereDate('appointments.created_at',Carbon::today())
                        ->join('patientses','patientses.id','=','appointments.patient_id')
                        ->join('invoices', 'invoices.appointment_id', '=', 'appointments.id')
                        ->orderBy('id','desc')
                        ->get();

                  */


                        $appointment = Appointment::with(['patient', 'chamber', 'doctor', 'payment_user', 'invoice'])
                        ->where('added_by',$request->user_id)
                        ->whereDate('appointments.created_at',Carbon::today())
                        ->take($request->limit)
                        ->skip($request->offset)
                        ->orderBy('id', 'desc')
                        ->get();

         

        return response(['status' => 1,'data' => $appointment]);
    }




    public function appointmentDetails(Request $request){


         $appointment=Appointment::where("id",$request->id)->first();

         $patient=Patients::where('id',$appointment->patient_id)->first();

         $doctor=User::where('id',$appointment->user_id)->first();

         return response(['status'=>1,'appointment'=>$appointment,'patient'=>$patient,'doctor'=>$doctor]);


    }

     
    public function VleDashboard(Request $request){


        $patients=Patients::where('added_by',$request->user_id)->count();

        $appointment= Appointment::where('added_by',$request->user_id)->count();

        $wallet=UserWallet::where(['user_id'=>$request->user_id,'user_role'=>'vle'])->first();

        $todayAppointment=Appointment::where('added_by',$request->user_id)->whereDate('created_at',Carbon::today())->count();

        $balance=$wallet->amount;
        
        $dashboard=array('patients'=>$patients,'appointments'=>$appointment,'balance'=>$balance,'today_appointment'=>$todayAppointment);

        return response(['status'=>1,'data'=>$dashboard]);


    }

}
