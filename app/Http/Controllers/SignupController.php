<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RideAuth;
use App\Models\RideData;
use App\Models\DriveAuth;
use App\Models\DriveData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class DevOpsSMS_API
{

    public function __construct() {
        $this->url = 'http://api.mymobileapi.com/api5/http5.aspx';
        $this->username = 'Intercity_Admin'; //your login username
        $this->password = '!nterc!ty$M$'; //your login password
        $this->time = '16:20';
                $this->validityperiod = '24';
    }
    
    public function checkCredits() {
        $data = array(
            'Type' => 'credits', 
            'Username' => $this->username,
            'Password' => $this->password
        );
        $response = $this->querySmsServer($data);
        // NULL response only if connection to sms server failed or timed out
        if ($response == NULL) {
            return '???';
        } elseif ($response->call_result->result) {
        echo '</br>Credits: ' .  $response->data->credits;
            return $response->data->credits;
        }
    }
    
   public function sendSms($mobile_number, $msg) {
        $data = array(
            'Type' => 'sendparam', 
            'Username' => $this->username,
            'Password' => $this->password,
            'numto' => $mobile_number, //phone numbers (can be comma seperated)
            'data1' => $msg, //your sms message
            'time' => $this->time, //the time your message will go out
                    'validityperiod' => $this->validityperiod, //the duration of validity

        );
        $response = $this->querySmsServer($data);
        return $this->returnResult($response);
    }
    
    // query API server and return response in object format
    private function querySmsServer($data, $optional_headers = null) {

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // prevent large delays in PHP execution by setting timeouts while connecting and querying the 3rd party server
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 2000); // response wait time
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 2000); // output response time
        $response = curl_exec($ch);
        if (!$response) return NULL;
        else return new SimpleXMLElement($response);
    }

    // handle sms server response
    private function returnResult($response) {
        $return = new StdClass();
        $return->pass = NULL;
        $return->msg = '';
        if ($response == NULL) {
            $return->pass = FALSE;
            $return->msg = 'SMS connection error.';
        } elseif ($response->call_result->result) {
            $return->pass = 'CallResult: '.TRUE . '</br>';
        $return->msg = 'EventId: '.$response->send_info->eventid .'</br>Error: '.$response->call_result->error;
        } else {
            $return->pass = 'CallResult: '.FALSE. '</br>';
            $return->msg = 'Error: '.$response->call_result->error;
        }
    echo $return->pass; 
    echo $return->msg; 
        return $return; 
    }
    
}

class SignupController extends Controller
{
   
    public function drivePersonalIndex(){
        return view("drive_signup_personal");
    }

    public function driveSignupCities(){
        return view("drive_signup_cities");
    }

    public function drivePersonal(Request $req){
        Session::put("firstname", ucwords($req->firstname));
        Session::put("lastname", ucwords($req->lastname));
        Session::put("phone", $req->phone);
        Session::put("gender", ucwords($req->gender));
        if(DriveAuth::where("drive_first_name", Session::get("firstname"))
        ->where("drive_last_name", Session::get("lastname"))
        ->where("drive_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        if(driveAuth::where("drive_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        return view("drive_signup_vehicle");
    }

    public function driveCities(Request $req){
        Session::put("cities", $req->cities);
        return view("drive_signup_password");
    }

    public function driveVehicle(Request $req){
        Session::put("vehiclename", ucwords($req->vehiclename));
        Session::put("vehicletype", ucwords($req->vehicletype));
        Session::put("vehicleplate", $req->vehicleplate);
        Session::put("vehiclecolor", ucwords($req->vehiclecolor));

        return view("drive_signup_cities");
    }


    public function driveSignup(Request $req){
        $drive = new DriveAuth();
        $drive->drive_first_name = Session::get("firstname");
        $drive->drive_last_name = Session::get("lastname");
        $drive->drive_phone = Session::get("phone");
        $drive->drive_gender = Session::get("gender");
        $drive->drive_password = Hash::make($req->password);

        $drive->save();

        $driveData = new DriveData();
        $driveData->drive_id = $drive->id;
        $driveData->drive_profile_image = "";
        $driveData->drive_vehicle = Session::get("vehiclename");
        $driveData->drive_vehicle_type = Session::get("vehicletype");
        $driveData->drive_vehicle_plate = Session::get("vehicleplate");
        $driveData->drive_vehicle_color = Session::get("vehiclecolor");
        $driveData->drive_cities = Session::get("cities");

        $driveData->save();

        Session::put("drive_id", $drive->id);
        Session::put("hasLogged", true);
        return redirect("/drive/dashboard");
    }

    public function ridePersonalIndex(){
        return view("ride_signup_personal");
    }

    public function ridePersonal(Request $req){
        Session::put("firstname", ucwords($req->firstname));
        Session::put("lastname", ucwords($req->lastname));
        Session::put("phone", $req->phone);
        Session::put("gender", ucwords($req->gender));

        //Execute script
        $test = new DevOpsSMS_API();
        $test->sendSms(strval($req->phone),'Test Message'); //Send SMS

        dd("ola");
        if(RideAuth::where("ride_first_name", Session::get("firstname"))
        ->where("ride_last_name", Session::get("lastname"))
        ->where("ride_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        if(RideAuth::where("ride_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        return view("ride_signup_password");
    }

    public function rideSignup(Request $req){
        $ride = new RideAuth();
        $ride->ride_first_name = Session::get("firstname");
        $ride->ride_last_name = Session::get("lastname");
        $ride->ride_phone = Session::get("phone");
        $ride->ride_gender = Session::get("gender");
        $ride->ride_password = Hash::make($req->password);

        $ride->save();

        $rideData = new RideData();
        $rideData->ride_id = $ride->id;
        $rideData->ride_profile_image = "";

        $rideData->save();

        Session::put("ride_id", $ride->id);
        Session::put("hasLogged", true);
        return redirect("/ride/dashboard");
    }
}
