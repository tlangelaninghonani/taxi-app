<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RideAuth;
use App\Models\RideData;
use App\Models\DriveAuth;
use App\Models\DriveData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


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

        /*$apiKey = '001bebab-db9e-4487-bfd9-21478566d29e';
        $apiSecret = 'ROBzNkvhADXW3UsA/qS4fN2sINLJ+OlN';
        $accountApiCredentials = $apiKey . ':' .$apiSecret;

        $base64Credentials = base64_encode($accountApiCredentials);
        $authHeader = 'Authorization: Basic ' . $base64Credentials;

        $authEndpoint = 'https://rest.mymobileapi.com/Authentication';

        $authOptions = array(
            'http' => array(
                'header'  => $authHeader,
                'method'  => 'GET',
                'ignore_errors' => true
            )
        );
        $authContext  = stream_context_create($authOptions);

        $result = file_get_contents($authEndpoint, false, $authContext);

        $authResult = json_decode($result);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];

        $sendUrl = 'https://rest.mymobileapi.com/bulkmessages';

        $authHeader = 'Authorization: Bearer ' . $authToken;

        $sendData = '{ "messages" : [ { "content" : "Ola mate", "destination" : "0677228944" } ] }';

        $options = array(
            'http' => array(
                'header'  => array("Content-Type: application/json", $authHeader),
                'method'  => 'POST',
                'content' => $sendData,
                'ignore_errors' => true
            )
        );
        $context  = stream_context_create($options);

        $sendResult = file_get_contents($sendUrl, false, $context);

        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = $match[1];*/

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

        $test = new DevOpsSMS_API();
        $test->sendSms("0677228944",'Test Message'); //Send SMS
        //$test->checkcredits(); //Check your credit balance

        dd("testing SMS API");

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
